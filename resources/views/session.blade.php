@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>جلسة فيديو مباشرة</h1>
    <div class="video-container">
        <div class="local-video-wrapper">
            <video id="localVideo" autoplay playsinline muted></video>
            <div id="localVideoStatus" class="video-status">الفيديو المحلي</div>
        </div>
        <div class="remote-video-wrapper">
            <video id="remoteVideo" autoplay playsinline></video>
            <div id="remoteVideoStatus" class="video-status">فيديو الطرف الآخر</div>
        </div>
    </div>

    <div class="session-controls">
        <button id="startCallBtn" class="btn btn-primary">بدء المكالمة</button>
        <button id="toggleVideoBtn" class="btn btn-secondary" style="display:none;">إيقاف الفيديو</button>
        <button id="toggleAudioBtn" class="btn btn-secondary" style="display:none;">كتم الصوت</button>
        <button id="endCallBtn" class="btn btn-danger" style="display:none;">إنهاء المكالمة</button>
    </div>
</div>

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
class VideoSessionManager {
    constructor(config) {
        this.localStream = null;
        this.peerConnection = null;
        this.remoteStream = null;
        this.config = {
            appointmentId: config.appointmentId,
            pusherKey: config.pusherKey,
            pusherCluster: config.pusherCluster,
            iceServers: [
                { urls: 'stun:stun.l.google.com:19302' },
                { urls: 'stun:stun1.l.google.com:19302' }
            ]
        };

        this.elements = {
            localVideo: document.getElementById('localVideo'),
            remoteVideo: document.getElementById('remoteVideo'),
            startCallBtn: document.getElementById('startCallBtn'),
            endCallBtn: document.getElementById('endCallBtn'),
            toggleVideoBtn: document.getElementById('toggleVideoBtn'),
            toggleAudioBtn: document.getElementById('toggleAudioBtn')
        };

        this.initializePusher();
        this.bindEvents();
    }

    initializePusher() {
        this.pusher = new Pusher(this.config.pusherKey, {
            cluster: this.config.pusherCluster,
            encrypted: true
        });

        this.channel = this.pusher.subscribe(`video-session-${this.config.appointmentId}`);
        this.setupSignalingListeners();
    }

    bindEvents() {
        this.elements.startCallBtn.addEventListener('click', () => this.startCall());
        this.elements.endCallBtn.addEventListener('click', () => this.endCall());
        this.elements.toggleVideoBtn.addEventListener('click', () => this.toggleVideo());
        this.elements.toggleAudioBtn.addEventListener('click', () => this.toggleAudio());
    }

    async requestMediaAccess() {
        try {
            const constraints = {
                video: { width: 640, height: 480 },
                audio: true
            };
            this.localStream = await navigator.mediaDevices.getUserMedia(constraints);
            this.elements.localVideo.srcObject = this.localStream;
            this.updateUIControls(true);
        } catch (error) {
            alert('تعذر الوصول إلى الكاميرا أو الميكروفون. يرجى السماح بذلك من المتصفح.');
            console.error(error);
        }
    }

    createPeerConnection() {
        this.peerConnection = new RTCPeerConnection({ iceServers: this.config.iceServers });

        this.peerConnection.onicecandidate = event => {
            if (event.candidate) {
                this.sendSignal('candidate', { candidate: event.candidate });
            }
        };

        this.peerConnection.ontrack = event => {
            this.remoteStream = event.streams[0];
            this.elements.remoteVideo.srcObject = this.remoteStream;
        };

        this.localStream.getTracks().forEach(track => {
            this.peerConnection.addTrack(track, this.localStream);
        });
    }

    setupSignalingListeners() {
        this.channel.bind('offer', async data => this.handleOffer(data.offer));
        this.channel.bind('answer', async data => this.handleAnswer(data.answer));
        this.channel.bind('candidate', async data => this.addCandidate(data.candidate));
    }

    async startCall() {
        await this.requestMediaAccess();
        this.createPeerConnection();

        const offer = await this.peerConnection.createOffer();
        await this.peerConnection.setLocalDescription(offer);

        this.sendSignal('offer', { offer });
    }

    async handleOffer(offer) {
        if (!this.peerConnection) {
            await this.requestMediaAccess();
            this.createPeerConnection();
        }

        await this.peerConnection.setRemoteDescription(new RTCSessionDescription(offer));
        const answer = await this.peerConnection.createAnswer();
        await this.peerConnection.setLocalDescription(answer);

        this.sendSignal('answer', { answer });
    }

    async handleAnswer(answer) {
        await this.peerConnection.setRemoteDescription(new RTCSessionDescription(answer));
    }

    async addCandidate(candidate) {
        try {
            await this.peerConnection.addIceCandidate(new RTCIceCandidate(candidate));
        } catch (error) {
            console.error('Error adding ICE candidate:', error);
        }
    }

    sendSignal(type, data) {
        fetch(`/session/${this.config.appointmentId}/signal`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ type, ...data })
        });
    }

    toggleVideo() {
        const videoTrack = this.localStream.getVideoTracks()[0];
        videoTrack.enabled = !videoTrack.enabled;
    }

    toggleAudio() {
        const audioTrack = this.localStream.getAudioTracks()[0];
        audioTrack.enabled = !audioTrack.enabled;
    }

    endCall() {
        if (this.peerConnection) {
            this.peerConnection.close();
        }
        this.updateUIControls(false);
    }

    updateUIControls(isCallActive) {
        this.elements.startCallBtn.style.display = isCallActive ? 'none' : 'inline-block';
        this.elements.endCallBtn.style.display = isCallActive ? 'inline-block' : 'none';
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new VideoSessionManager({
        appointmentId: "{{ $appointment->id }}",
        pusherKey: "{{ env('PUSHER_APP_KEY') }}",
        pusherCluster: "{{ env('PUSHER_APP_CLUSTER') }}"
    });
});
</script>

<style>
.video-container {
    display: flex;
    justify-content: space-between;
    gap: 20px;
}
</style>
@endsection
