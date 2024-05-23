<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <!-- Container wrapper -->
    <div class="container-fluid">
        <!-- Toggle button -->
        <button class="navbar-toggler" type="button" data-mdb-toggle="collapse"
            data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Collapsible wrapper -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Navbar brand -->
            <a class="navbar-brand mt-2 mt-lg-0" href="#">

            </a>
            <!-- Left links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <img src="https://www.vectorkhazana.com/assets/images/products/Lion-head.jpg"
                            style="width: 30px">
                        Coders Blog
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href=""><i class="fa-brands fa-hive"></i> Blogs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/Coders/PROJECT/client/categories/index.php"><i
                            class="fa-solid fa-bars"></i>
                        Categories</a>
                </li>

            </ul>
            <!-- Left links -->
        </div>

        <div class="d-flex align-items-center">
            <?php
            if (!isset($_SESSION['userId'])) {
                ?>
                <div>
                    <!-- Icon -->
                    <a class="text-reset me-3" href="http://localhost/Coders/PROJECT/auth/register.php"
                        style="text-decoration: none">
                        <i class="fa-solid fa-pen-to-square"></i>
                        Register
                    </a>
                </div>
                <div>
                    <a class="text-reset me-3" href="http://localhost/Coders/PROJECT/auth/login.php"
                        style="text-decoration: none">
                        <i class="fa-solid fa-right-to-bracket"></i>
                        Login
                    </a>
                </div>
                <?php
            }
            ?>
            <?php
            $href = $_SESSION['userId'] ?? null ? "../client/userPage.php" : '';
            ?>
            <a class="text-reset me-3" href=<?= $href ?> style="text-decoration: none">

                <?php
                if (isset($_SESSION['userImg'])) {
                    ?>
                    <img style="height:40px;width:40px;border-radius:50%;object-fit:cover;"
                        src="<?= $_SESSION['userImg'] ?>" alt="">
                    <?php
                }
                echo $_SESSION['userName'] ?? null
                    ?>
            </a>
            <?php
            if (isset($_SESSION['userId'])):
                ?>
                <a class="text-reset me-3" href="/Coders/PROJECT/auth/logout.php" style="text-decoration: none">

                    <i class="fa-solid fa-right-from-bracket"></i>
                    Logout
                </a>
                <?php
            endif;
            ?>
        </div>
    </div>
</nav>