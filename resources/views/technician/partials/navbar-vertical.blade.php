 
 <!-- Sidebar -->
 <nav class="navbar-vertical navbar">
     <div class="nav-scroller">
         <!-- Brand logo -->
         <a class="navbar-brand" href="@@webRoot/index.html">
             <img src="@@webRoot/assets/images/brand/logo/logo.svg" alt="" />
         </a>
         <!-- Navbar nav -->
         <ul class="navbar-nav flex-column" id="sideNavbar">
             <li class="nav-item">
                 <a class="nav-link has-arrow @@if (context.page ===  'dashboard') { active }"
                     href="@@webRoot/index.html">
                     <i data-feather="home" class="nav-icon icon-xs me-2"></i> Dashboards
                 </a>

             </li>

             <!-- Nav item -->
             <li class="nav-item">
                 <a class="nav-link has-arrow @@if (context.page_group !== 'pages') { collapsed }"
                     href="#!" data-bs-toggle="collapse" data-bs-target="#navPages" aria-expanded="false"
                     aria-controls="navPages">
                     <i data-feather="layers" class="nav-icon icon-xs me-2">
                     </i> Pages
                 </a>

                 <div id="navPages"
                     class="collapse @@if (context.page_group === 'pages') { show }"
                     data-bs-parent="#sideNavbar">
                     <ul class="nav flex-column">
                         <li class="nav-item">
                             <a class="nav-link @@if (context.page === 'profile') { active }"
                                 href="@@webRoot/pages/profile.html">
                                 Profile
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link has-arrow  @@if (context.page === 'settings') { active } "
                                 href="{{ route('technician.settings') }}">
                                 Settings
                             </a>

                         </li>


                         <li class="nav-item">
                             <a class="nav-link @@if (context.page === 'billing') { active }"
                                 href="@@webRoot/pages/billing.html">
                                 Billing
                             </a>
                         </li>




                         <li class="nav-item">
                             <a class="nav-link @@if (context.page === 'pricing') { active }"
                                 href="@@webRoot/pages/pricing.html">
                                 Pricing
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link @@if (context.page === '404error') { active }"
                                 href="@@webRoot/pages/404-error.html">
                                 404 Error
                             </a>
                         </li>
                     </ul>
                 </div>
             </li>


             <!-- Nav item -->
             <li class="nav-item">
                <a class="nav-link has-arrow @@if (context.page_group !== 'orders') { collapsed }"
                   href="#!" data-bs-toggle="collapse" data-bs-target="#navOrders" aria-expanded="false"
                   aria-controls="navOrders">
                    <i data-feather="shopping-cart" class="nav-icon icon-xs me-2"></i> Orders
                </a>
            
                <div id="navOrders"
                     class="collapse @@if (context.page_group === 'orders') { show }">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'orderRequests') { active }"
                               href="{{ route('technician.orders.requests') }}">
                               Order Requests
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'pendingOrders') { active }"
                               href="{{ route('technician.orders.pending') }}">
                               Pending Orders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'completedOrders') { active }"
                               href="{{ route('technician.orders.completed') }}">
                               Completed Orders
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            


           
             <li class="nav-item">
                 <a class="nav-link @@if (context.page === 'layouts') { active }"
                     href="@@webRoot/pages/layout.html">
                     <i data-feather="sidebar" class="nav-icon icon-xs me-2">
                     </i>
                     Layouts
                 </a>
             </li>

           
        

             <!-- Nav item -->
             <li class="nav-item">
                 <div class="navbar-heading">Documentation</div>
             </li>

             <!-- Nav item -->
             <li class="nav-item">
                 <a class="nav-link has-arrow @@if (context.page === 'docs') { active }"
                     href="@@webRoot/docs/index.html">
                     <i data-feather="clipboard" class="nav-icon icon-xs me-2">
                     </i> Docs
                 </a>
             </li>




         </ul>

     </div>
 </nav>
