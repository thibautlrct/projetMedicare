<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicare - Accueil</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <header>
        <div class="header-content">
            <h1>Medicare: Services Médicaux</h1>
            <img src="MedicareLogo.jpg" alt="Medicare Logo">
        </div>
        <?php include 'php/nav.php';?>
    </header>

    <main>
        <h2>Bienvenue sur Medicare</h2>
        <p>Votre plateforme de services médicaux en ligne.</p>
        <section>
            <h2>Qu'est-ce que Medicare ?</h2>
            <p>
                Medicare est une plateforme dédiée à la gestion des rendez-vous médicaux.
                Elle permet aux patients de rechercher des médecins, de prendre des rendez-vous
                et de gérer leurs consultations en toute simplicité. Notre objectif est de faciliter
                l'accès aux soins de santé en offrant un service convivial et efficace tant pour les
                patients que pour les professionnels de santé.
            </p>
        </section>
        <section class="event-of-the-week">
            <h2>L’Évènement de la semaine</h2>
            <p>
                Cette semaine, nous avons le plaisir de vous inviter à notre <strong>séminaire annuel de santé</strong>,
                qui se tiendra le vendredi 28 mai de 10h à 16h. C'est une excellente occasion de rencontrer nos experts,
                de participer à des ateliers interactifs et d'en apprendre davantage sur les dernières avancées en
                matière
                de santé et de bien-être. N'hésitez pas à nous rejoindre pour une journée enrichissante et informative!
            </p>
            <div class="carousel">
                <img src="cardiologue.jpg" alt="Image 1" class="active">
                <img src="dermatologie.jpg" alt="Image 2">
                <img src="gastro.jpg" alt="Image 3">
                <img src="ostheopathe.jpg" alt="Image 4">
                <div class="carousel-controls">
                    <button id="prevBtn">‹</button>
                    <button id="nextBtn">›</button>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <div class="footer-content">
            <p>Contactez-nous: <a href="mailto:contact@medicare.com">contact@medicare.com</a></p>
            <a href="https://www.google.com/maps?q=40+rue+Worth,+92150+Suresnes" target="_blank">
                <img src="localisation.png" alt="Icone Google Maps">
            </a>
        </div>
    </footer>
    <script>
        const carouselImages = document.querySelectorAll('.carousel img');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        let currentIndex = 0;

        function showImage(index) {
            carouselImages.forEach((img, i) => {
                img.classList.toggle('active', i === index);
            });
        }

        function nextImage() {
            currentIndex = (currentIndex < carouselImages.length - 1) ? currentIndex + 1 : 0;
            showImage(currentIndex);
        }

        function prevImage() {
            currentIndex = (currentIndex > 0) ? currentIndex - 1 : carouselImages.length - 1;
            showImage(currentIndex);
        }

        prevBtn.addEventListener('click', prevImage);
        nextBtn.addEventListener('click', nextImage);

        setInterval(nextImage, 5000);
    </script>
</body>

</html>