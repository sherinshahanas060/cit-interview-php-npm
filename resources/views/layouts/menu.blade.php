
 <div class="nav nav-tree-a  flex-column nav-tabs" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
    <a class="p-0 text-center active" id="vert-tabs-home-tab" data-toggle="pill" href="#vert-tabs-home" role="tab" aria-controls="vert-tabs-home" aria-selected="true">
        <router-link :to="{name : 'dashboard'}">
            <i class="fas fa-home"></i>
            <p>Home</p>
        </router-link>
    </a>
    
    <a class="nav-link p-0 text-center" id="vert-tabs-settings-tab" data-toggle="pill" href="#vert-tabs-settings" role="tab" aria-controls="vert-tabs-settings" aria-selected="false">
        <i class="fas fa-cart-arrow-down"></i>
        <p>User</p>
    </a>
    
    @can('Cms')
    <a class="nav-link p-0 text-center" id="vert-tabs-blog-tab" data-toggle="pill" href="#vert-tabs-blogs" role="tab" aria-controls="vert-tabs-blogs" aria-selected="false">
        <i class="fas fa-cart-arrow-down"></i>
        <p>Blogs</p>
    </a>
    @endcan
    <a class="nav-link p-0 text-center" id="vert-tabs-developer-tab" data-toggle="pill" href="#vert-tabs-developer" role="tab" aria-controls="vert-tabs-developer" aria-selected="false">
        <i class="fas fa-cart-arrow-down"></i>
        <p>Developer</p>
    </a>
</div>
</div>
 <div class="right-m-bar">
    <div class="tab-content" id="vert-tabs-tabContent">
        <!--start menu Home-->
        <div class="col-12">
            <span class="brand-text font-weight-light">Aizove</span>
        </div>
        <div class="col-12">DIRECTORIES</div>
        <div class="tab-pane fade active show" id="vert-tabs-home" role="tabpanel" aria-labelledby="vert-tabs-home-tab">
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <input type="text" class="menufilter" placeholder="Search for menu..">

                    <ul class="nav custom-nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        
                        <li class="nav-item">
                            <router-link :to="{name : 'dashboard'}" class="nav-link">
                                <i class="fas fa-circle-notch nav-icon"></i>
                                <p>
                                Dashboard
                                </p>
                            </router-link>
                        </li>
                       
                        
                    </ul>

                </nav>
            </div>
        </div>
        <!--end menu Home-->

        <!--start menu Developer-->
        <div class="tab-pane fade" id="vert-tabs-developer" role="tabpanel" aria-labelledby="vert-tabs-developer-tab">
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <input type="text" class="menufilter" placeholder="Search for menu..">

                    <ul class="nav custom-nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        
                       
                        <li class="nav-item">
                            <router-link :to="{name : 'developer'}" class="nav-link">
                                <i class="fas fa-circle-notch nav-icon"></i>
                                <p>
                                Developer
                                </p>
                            </router-link>
                        </li>
                        
                    </ul>

                </nav>
            </div>
        </div>
        <!--end menu Developer-->

        <!--start menu Settings-->
        <div class="tab-pane fade" id="vert-tabs-settings" role="tabpanel" aria-labelledby="vert-tabs-settings-tab">
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <input type="text" class="menufilter" placeholder="Search for menu..">

                    <ul class="nav custom-nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        
                    @can('Role')
                        <li class="nav-item">
                            <router-link :to="{name : 'permissions'}" class="nav-link">
                                <i class="fas fa-circle-notch nav-icon"></i>
                                <p>
                                Permissions
                                </p>
                            </router-link>
                        </li>
                        @endcan
                        @can('User')
                        <li class="nav-item">
                            <router-link :to="{ name: 'users'}" class="nav-link">
                                <i class="nav-icon fas fa-user-tie"></i>
                                <p>
                                    Users
                                </p>
                            </router-link>
                        </li>
                        @endcan
                        <li class="nav-item">
                            <router-link :to="{ name : 'logreports' }" class="nav-link">
                                <i class="fas fa-circle-notch nav-icon"></i>
                                <p>Log Report</p>
                            </router-link>
                        </li>
                        
                    </ul>

                </nav>
            </div>
        </div>
        <!--end menu Settings-->
        <!--start menu Blog-->
        <div class="tab-pane fade" id="vert-tabs-blogs" role="tabpanel" aria-labelledby="vert-tabs-blogs-tab">
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <input type="text" class="menufilter" placeholder="Search for menu..">

                    <ul class="nav custom-nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        
                       
                        <li class="nav-item">
                            <router-link :to="{name : 'blogs'}" class="nav-link">
                                <i class="fas fa-circle-notch nav-icon"></i>
                                <p>
                                Blog
                                </p>
                            </router-link>
                        </li>
                       
                    </ul>

                </nav>
            </div>
        </div>
        <!--end menu Blog-->
        
    </div>
</div>
