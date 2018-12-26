<header>
    <div id="sign">
        <ul>
            <?php 
            if(isset($_SESSION['nom']) && isset($_SESSION['prenom'])) {
                echo '<li class="header_name">Bienvenue '.$_SESSION['prenom'].' '.$_SESSION['nom'].'</li>';
                echo '<li class="signitem"><a href="deconnexion.php">Deconnexion</a></li>';
            } else {
                echo '<li class="signitem"><a href="inscription.php">S\'inscrire</a></li>';
                echo '<li class="signitem"><a href="connexion.php">Connexion</a></li>';
            }
            if(isset($_SESSION['nom']) && $_SESSION['email'] == 'admin@gmail.com') {
                echo '<li class="signitem"><a href="administration.php">Administration</a></li>';
            }
            echo '<li class="signitem"><a href="#">Mon panier</a></li>';
            ?>

        </ul>		
    </div>
    <nav>
        <ul id="navbar">
            <li class="navitem"><a href="index.php">Accueil</a></li>
            <li class="navitem"><a href="produits.php">Produits</a></li>
            <li class="navitem"><a href="contact.php">Contact</a></li>
        </ul>
    </nav>
</header>
<hr>