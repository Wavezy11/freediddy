<?php
// index.php

// Databaseverbinding
$host = 'localhost';
$db = 'pit landing-page'; // Vervang dit door je database naam
$user = 'root'; // Vervang dit door je database gebruikersnaam
$pass = ''; // Vervang dit door je database wachtwoord

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}



$appsPerPage = 12;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page > 1) ? ($page * $appsPerPage) - $appsPerPage : 0;

// Ophalen van het totaal aantal apps voor paginering
$totalApps = $pdo->query('SELECT COUNT(*) FROM apps')->fetchColumn();
$totalPages = ceil($totalApps / $appsPerPage);




// Ophalen van apps uit de database
$stmt = $pdo->prepare("SELECT * FROM apps ORDER BY id DESC LIMIT :start, :appsPerPage");
$stmt->bindParam(':start', $start, PDO::PARAM_INT);
$stmt->bindParam(':appsPerPage', $appsPerPage, PDO::PARAM_INT);
$stmt->execute();
$apps = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landingpage PIT</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>

<header>
    <img src="img/Yonder.png" alt="logo">
    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
        <a href="php/upload.php"> <button>Edit</button> </a>
    <?php endif; ?>
        


    <form action="" method="post">
        <input type="search" id="search" name="search">
    </form>

    <div class="studenten">Voor studenten</div>
    <div class="studenten2">Voor volwassenen</div>
    <div class="studenten3">Voor bedrijven</div>
</header>

   
    <main>

        <section id="hero"> 
        <section class="texts"> <div class="textss"> 
   
 <br> <h1> <p class="subtitel">Onze projecten</p> </h1>
<br>
<p class="subtext">
Yonder staat graag dichtbij toekomstige veranderingen. Een aantal docenten maakt deel uit van Kopgroep Interactieve Technologie. De kopgroep ontwikkelt onderwijs
met behulp van interactieve technologie.</p>
</div> 
<div id="vrimg">
    <img src="img\vr-girl.jpeg" alt="foto van een meid">
    </div>
</section>
    </section>
        <br><br>
  
     
        <div class="container">
            <?php foreach ($apps as $row): ?>
                <div class="app" data-title="<?= htmlspecialchars($row['title']) ?>" data-description="<?= htmlspecialchars($row['description']) ?>" data-image="img/<?= htmlspecialchars($row['image']) ?>" data-link="<?= htmlspecialchars($row['link']) ?>">
                    <img class="homepage-image" src="img/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['title']) ?>">
                    <p class="app-date"><?= date('d F Y', strtotime($row['created_at'])) ?></p>
                    <p class="apptitle"><?= htmlspecialchars($row['title']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i ?>" class="<?= ($i == $page) ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>




        <div id="popupOverlay" class="overlay"></div>
        <div id="myPopup" class="popup">
            <span class="close" onclick="togglePopup()">×</span>
            <div class="popup-content">
                <div class="popup-left">
                    <img id="popupImage" src="" alt="Popup Image">
                </div>
                <div class="popup-right">
                    <h2 id="popupTitle">Popup Title</h2>
                    <p id="popupDescription">Popup description goes here.</p>
                    <button id="popupbutton" onclick="window.open('', '_blank')">Link naar de applicatie</button>
                </div>
            </div>
        </div>

        

        <script src="js/index.js"></script>
    </main>

    <footer>
    <div class="footer-container">

                <!-- <img src="img\Yonder-Full-White.png" alt="logo" class="logofooter"> -->
        <div class="footer-section">
            <h3>Voor studenten</h3>
            <ul>
                <li><a href="#">Opleidingen</a></li>
                <li><a href="#">Studie kiezen</a></li>
                <li><a href="#">Op school</a></li>
                <li><a href="#">Over Yonder</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Voor volwassenen</h3>
            <ul>
                <li><a href="#">Vakgebieden</a></li>
                <li><a href="#">Opleidingen</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Voor bedrijven</h3>
            <ul>
                <li><a href="#">Vakgebieden</a></li>
                <li><a href="#">Opleidingen</a></li>
                <li><a href="#">Kennisbank</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Over Yonder</h3>
            <ul>
                <li><a href="#">Werken bij</a></li>
                <li><a href="#">Onze locaties</a></li>
                <li><a href="#">Bestuur en directie</a></li>
                <li><a href="#">Pers</a></li>
                <li><a href="#">Privacy statement</a></li>
                <li><a href="#">Meldpunt</a></li>
                <li><a href="#">Practoraat</a></li>
                <li><a href="#">Reglementen</a></li>
                <li><a href="#">Jaarverslag</a></li>
                <li><a href="#">Onze bouwprojecten</a></li>
            </ul>
        </div>
        <div class="footer-contact">
            <!-- <div class="belons"> <a href="#">Bel ons</a></div>
            <div class="mailons">   <a href="#">Mail ons</a> </div>
          -->
            <!-- <div class="social-icons">
                <a href="#"><img src="img/facebook.png" alt="Facebook"></a>
                <a href="#"><img src="img/instagram-icon.png" alt="Instagram"></a>
                <a href="#"><img src="img/linkedin-icon.png" alt="LinkedIn"></a>
                <a href="#"><img src="img/youtube-icon.png" alt="YouTube"></a>
            </div> -->
        </div>
    </div>
    <p>&copy; <?= date('Y') ?> Yonder. Alle rechten voorbehouden.</p>
</footer>
