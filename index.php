<?php include 'connexion.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion de Stock</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="header">
        <img src="stock.png" alt="Gestion de stock" style="width:200%; max-width:300px;">
            <h2>Gestion de Stock</h2>
        </div>
        <form method="post" class="form">
            <input type="hidden" name="id_modif" value="<?php echo isset($_GET['edit']) ? $_GET['edit'] : ''; ?>">
            <input type="text" name="nom" required placeholder="Nom du produit">
            <input type="number" name="quantite" required placeholder="Quantité">
            <input type="number" step="1" name="prix" required placeholder="Prix (en dh)">
            <div class="btn-center">
                <button type="submit" name="<?php echo isset($_GET['edit']) ? 'modifier' : 'ajouter'; ?>">
                    <?php echo isset($_GET['edit']) ? ' Modifier' : ' Ajouter'; ?>
                </button>
            </div>
        </form>
        <form method="get" class="search-form">
            <input type="text" name="search" placeholder=" Rechercher par nom">
            <button type="submit">Rechercher</button>
        </form>

        <?php
        if (isset($_POST['ajouter'])) {
            $nom = $_POST['nom'];
            $quantite = $_POST['quantite'];
            $prix = $_POST['prix'];
            $conn->query("INSERT INTO produits(nom, quantite, prix) VALUES ('$nom', '$quantite', '$prix')");
            echo "<p class='success'> Produit ajouté avec succès !</p>";
        }
if (isset($_POST['modifier'])) {
    $id = $_POST['id_modif'];
    $nom = $_POST['nom'];
    $quantite = $_POST['quantite'];
    $prix = $_POST['prix'];
    $conn->query("UPDATE produits SET nom='$nom', quantite='$quantite', prix='$prix' WHERE id=$id");
    echo "<p class='info'> Produit modifié avec succès !</p>";
    header("Location: index.php"); 
    exit();
}
        if (isset($_GET['delete'])) {
            $id = $_GET['delete'];
            $conn->query("DELETE FROM produits WHERE id=$id");
            echo "<p class='error'> Produit supprimé avec succès !</p>";
        }
        if (isset($_GET['search']) && $_GET['search'] != "") {
            $search = $_GET['search'];
            $res = $conn->query("SELECT * FROM produits WHERE nom LIKE '%$search%'");

            if ($res->num_rows > 0) {
                echo "<h3> Résultat de la recherche :</h3><ul>";
                while ($row = $res->fetch_assoc()) {
                    echo "<li>{$row['nom']} - Quantité: {$row['quantite']} - Prix: {$row['prix']} dh -  Date : {$row['date_ajout']}</li>";
                }
                echo "</ul>";
            } else {
                echo "<p class='error'> Aucun produit trouvé avec le nom '<strong>$search</strong>'.</p>";
            }
        }
        echo "<h3> Liste des produits :</h3>";
        $result = $conn->query("SELECT * FROM produits ORDER BY date_ajout DESC");
        echo "<div class='table-wrapper'><table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Quantité</th>
                        <th>Prix</th>
                        <th>Date d'ajout</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['nom']}</td>
                    <td>{$row['quantite']}</td>
                    <td>{$row['prix']} dh</td>
                    <td>{$row['date_ajout']}</td>
                    <td>
                        <a class='btn-edit' href='?edit={$row['id']}'> Modifier</a>
                        <a class='btn-delete' href='?delete={$row['id']}' onclick='return confirm(\"Supprimer ce produit ?\")'> Supprimer</a>
                    </td>
                  </tr>";
        }
        echo "</tbody></table></div>";
        ?>
    </div>
</body>
</html>
