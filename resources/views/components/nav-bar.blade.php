  <!-- Start Header -->
  <header id="navigation">
      <div class="container-fluid">
          <div class="row">
              <div class="col-30 left-col align-self-center">
                  <div class="site-logo">
                      <a href="index.html"><img src="assets/logo.png" alt="{{ $user }}" width="90"></a>
                  </div>

              </div><!-- End Col -->

              <div class="col-40 justify-content-center d-flex align-self-center">
                  <nav id="main-menu">
                      <ul>
                          <li class="menu-item-has-children">
                              <a href="#">Home</a>
                              <ul class="sub-menu">
                                  <li><a href="index.html">Home One</a></li>
                                  <li><a href="index-2.html">Home Two</a></li>
                              </ul>
                          </li>

                          <li class="menu-item-has-children">
                              <a href="#">Courses</a>
                              <ul class="sub-menu">
                                  <li><a href="courses.html">Course Style1</a></li>
                                  <li><a href="courses-2.html">Course Style2</a></li>
                                  <li><a href="course-details.html">Course Details</a></li>
                              </ul>
                          </li>

                          <li class="menu-item-has-children">
                              <a href="#">Pages</a>
                              <ul class="sub-menu">
                                  <li><a href="grid-blog.html">Grid Blog</a></li>
                                  <li><a href="standard-blog.html">Standard Blog</a></li>
                                  <li><a href="blog-details.html">Blog Details</a></li>
                                  <li><a href="cart.html">Cart</a></li>
                                  <li><a href="checkout.html">Checkout</a></li>
                                  <li><a href="login.html">Login</a></li>
                                  <li><a href="register.html">Register</a></li>
                                  <li><a href="about.html">About</a></li>
                                  <li><a href="instructors.html">Instructors</a></li>
                                  <li><a href="404.html">404</a></li>
                              </ul>
                          </li>

                          <li>
                              <a href="standard-blog.html">Blog</a>
                          </li>

                          <li>
                              <a href="contact.html">Contact</a>
                          </li>
                      </ul>
                  </nav>
              </div><!-- End Col -->

              <div class="col-30 right-col align-self-center text-end">
                  <div class="searchcart">
                      <!-- Dropdown Container -->
                      <div class="dropdown">
                          <button class="dropdown-button" onclick="toggleDropdown()">
                              <!-- Globe SVG Icon -->
                              <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                  xmlns="http://www.w3.org/2000/svg">
                                  <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" />
                                  <path d="M2 12h20M12 2v20M7 12c0-5.333 2-10 5-10s5 4.667 5 10-2 10-5 10-5-4.667-5-10z"
                                      stroke="currentColor" stroke-width="2" />
                              </svg>
                          </button>
                          <div class="dropdown-menu" id="dropdownMenu">
                              <div class="dropdown-content">
                                  <!-- Arabic Option -->
                                  <div class="dropdown-item">
                                      <label for="arabic">
                                          <span class="dropdown-option">
                                              <img src="https://user-images.githubusercontent.com/48198054/54481207-c3b57000-4842-11e9-8420-20e3b82f4b82.png"
                                                  alt="Arabic" class="dropdown-icon">
                                              Arabic
                                          </span>
                                      </label>
                                      <input type="radio" name="language" id="arabic"
                                          onclick="changeLanguage('ar')"
                                          {{ app()->getLocale() === 'ar' ? 'checked' : '' }}>
                                  </div>
                                  <!-- English Option -->
                                  <div class="dropdown-item">
                                      <label for="english">
                                          <span class="dropdown-option">
                                              <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a5/Flag_of_the_United_Kingdom_%281-2%29.svg/1200px-Flag_of_the_United_Kingdom_%281-2%29.svg.png"
                                                  alt="English" class="dropdown-icon">
                                              English
                                          </span>
                                      </label>
                                      <input type="radio" name="language" id="english"
                                          onclick="changeLanguage('en')"
                                          {{ app()->getLocale() === 'en' ? 'checked' : '' }}>
                                  </div>
                              </div>
                          </div>
                      </div>

                      <script>
                          function toggleDropdown() {
                              document.getElementById("dropdownMenu").classList.toggle("show");
                          }

                          function changeLanguage(lang) {
                              let url = lang === 'ar' ? "{{ LaravelLocalization::getLocalizedURL('ar') }}" :
                                  "{{ LaravelLocalization::getLocalizedURL('en') }}";
                              window.location.href = url;
                          }

                          // Close dropdown if clicked outside
                          window.onclick = function(event) {
                              if (!event.target.matches('.dropdown-button')) {
                                  let dropdowns = document.getElementsByClassName("dropdown-menu");
                                  for (let i = 0; i < dropdowns.length; i++) {
                                      let openDropdown = dropdowns[i];
                                      if (openDropdown.classList.contains('show')) {
                                          openDropdown.classList.remove('show');
                                      }
                                  }
                              }
                          }
                      </script>

                      <style>
                          /* Basic Dropdown Styles */
                          .dropdown {
                              position: relative;
                              display: inline-block;
                          }

                          .dropdown-button {
                              background-color: #f0f0f0;
                              border: none;
                              cursor: pointer;
                              padding: 10px;
                              border-radius: 50%;
                              font-size: 18px;
                              color: #333;
                          }

                          .dropdown-menu {
                              display: none;
                              position: absolute;
                              top: 100%;
                              right: 0;
                              background-color: #ffffff;
                              box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                              border-radius: 8px;
                              width: 200px;
                              z-index: 1;
                          }

                          .dropdown-menu.show {
                              display: block;
                          }

                          .dropdown-content {
                              max-height: 200px;
                              overflow-y: auto;
                              padding: 10px;
                          }

                          .dropdown-item {
                              display: flex;
                              justify-content: space-between;
                              align-items: center;
                              padding: 8px 0;
                              cursor: pointer;
                          }

                          .dropdown-item label {
                              cursor: pointer;
                              display: flex;
                              align-items: center;
                              gap: 10px;
                              color: #333;
                          }

                          .dropdown-option {
                              display: flex;
                              align-items: center;
                          }

                          .dropdown-icon {
                              width: 24px;
                              height: 24px;
                              border-radius: 50%;
                              border: 1px solid #ddd;
                          }

                          .dropdown-item input[type="radio"] {
                              cursor: pointer;
                          }

                          .dropdown-item:hover {
                              background-color: #f0f0f0;
                          }
                      </style>

                  </div>
                  <a href="#" class="white-btn bt">Login / Register</a>
              </div><!-- End Col -->

              <ul class='mobile_menu'>
                  <li class="menu-item-has-children">
                      <a href="#">Home</a>
                      <ul class="sub-menu">
                          <li><a href="index.html">Home One</a></li>
                          <li><a href="index-2.html">Home Two</a></li>
                      </ul>
                  </li>

                  <li class="menu-item-has-children">
                      <a href="#">Courses</a>
                      <ul class="sub-menu">
                          <li><a href="courses.html">Course Style1</a></li>
                          <li><a href="courses-2.html">Course Style2</a></li>
                          <li><a href="course-details.html">Course Details</a></li>
                      </ul>
                  </li>

                  <li class="menu-item-has-children">
                      <a href="#">Pages</a>
                      <ul class="sub-menu">
                          <li><a href="grid-blog.html">Grid Blog</a></li>
                          <li><a href="standard-blog.html">Standard Blog</a></li>
                          <li><a href="blog-details.html">Blog Details</a></li>
                          <li><a href="cart.html">Cart</a></li>
                          <li><a href="checkout.html">Checkout</a></li>
                          <li><a href="login.html">Login</a></li>
                          <li><a href="register.html">Register</a></li>
                          <li><a href="about.html">About</a></li>
                          <li><a href="instructors.html">Instructors</a></li>
                          <li><a href="404.html">404</a></li>
                      </ul>
                  </li>

                  <li>
                      <a href="standard-blog.html">Blog</a>
                  </li>

                  <li>
                      <a href="contact.html">Contact</a>
                  </li>
              </ul>
          </div>
      </div>






  </header>
  <!-- End Header -->
