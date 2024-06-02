<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laboratoire de Biologie Médicale - Services</title>
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
        <section>
            <h2>Nos Services</h2>
            <button onclick="loadServices()">Voir nos services</button>
            <div id="services-list">
                <!-- Les services seront affichés ici -->
            </div>
        </section>
        <section>
            <h2>Prendre Rendez-vous</h2>
            <div id="appointment-form" style="display:none;">
                <form id="schedule-form">
                    <label for="service">Service :</label>
                    <select id="service" name="service" required></select>
                    <label for="datetime">Date et heure :</label>
                    <input type="datetime-local" id="datetime" name="datetime" required>
                    <button type="submit">Prendre RDV</button>
                </form>
            </div>
        </section>
    </main>
    <footer>
        <div class="footer-content">
            <p>Contactez-nous : <a href="mailto:contact@medicare.com">contact@medicare.com</a></p>
            <a href="https://www.google.com/maps?q=40+rue+Worth,+92150+Suresnes" target="_blank">
                <img src="localisation.png" alt="Icone Google Maps">
            </a>
        </div>
    </footer>
    <script>
        function loadServices() {
            fetch('php/get_services.php')
                .then(response => response.json())
                .then(data => {
                    const servicesList = document.getElementById('services-list');
                    servicesList.innerHTML = '';
                    data.forEach(service => {
                        const serviceDiv = document.createElement('div');
                        serviceDiv.classList.add('service');
                        serviceDiv.innerHTML = `<h3>${service.nom}</h3><p>${service.description}</p>`;
                        serviceDiv.onclick = () => {
                            document.getElementById('appointment-form').style.display = 'block';
                            document.getElementById('service').innerHTML = `<option value="${service.id}">${service.nom}</option>`;
                        };
                        servicesList.appendChild(serviceDiv);
                    });
                });
        }

        document.getElementById('schedule-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);

            fetch('php/schedule_lab_appointment.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                document.getElementById('appointment-form').style.display = 'none';
            });
        });
    </script>
</body>
</html>
