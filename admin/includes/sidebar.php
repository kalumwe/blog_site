

                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="index.php?page=dashboard">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading">Manage Posts </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Posts
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="index.php?page=posts">Manage posts</a>
                                    <a class="nav-link" href="index.php?page=author">Manage author</a>
                                    <a class="nav-link" href="index.php?page=manage-comments">Manage comments</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" 
                               aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Category
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                        
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="index.php?page=category">Manage categories</a>
                                            
                                        </nav>
                                    </div>
                                    
                            <div class="sb-sidenav-menu-heading">Admin</div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseSettings" aria-expanded="false" aria-controls="collapseSettings">
                                <div class="sb-nav-link-icon"><i class="fas fa-cog"></i></div>
                                Settings
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseSettings" aria-labelledby="headingThree" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                   <a class="nav-link" href="index.php?page=settings">Change Password</a>
                                   <a class="nav-link" href="index.php?page=site_settings">Site Settings</a>
                                    </nav>
                              </div>
                            <a class="nav-link" href="index.php?page=user-account">
                                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                User Account
                            </a>
                            
                        </div>
                    </div>
                    <?php 
                        $sql  = "SELECT CONCAT(first_name, ' ', last_name) AS name FROM users WHERE id=$user_id";
                        $query = $conn->query($sql);
                        $row = $query->fetch();
                    ?>
                    <div class="sb-sidenav-footer">
                        <div class="small my-2">Logged in as: <?php echo $user->safe($row['name']); ?></div>
                        KaluBlog Admin 
                    </div>