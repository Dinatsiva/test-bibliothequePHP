<?php
class Emprunt {
    private $conn;
    private $table = "emprunt";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Vérifier si un exemplaire est disponible
    public function isDisponible($id_exemplaire) {
        $sql = "SELECT disponible FROM exemplaire WHERE id_exemplaire = :id_exemplaire LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id_exemplaire", $id_exemplaire);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($res && $res['disponible'] === 'oui');
    }

    // Emprunter un exemplaire
    public function emprunter($id_utilisateur, $id_exemplaire, $date_retour_prevue) {
        if (!$this->isDisponible($id_exemplaire)) {
            return false;
        }

        // Insérer dans emprunt
        $sql = "INSERT INTO $this->table (id_utilisateur, id_livre, date_emprunt, date_retour_prevue, statut)
                SELECT :id_utilisateur, id_livre, CURDATE(), :date_retour_prevue, 'en cours'
                FROM exemplaire WHERE id_exemplaire = :id_exemplaire";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id_utilisateur", $id_utilisateur);
        $stmt->bindParam(":date_retour_prevue", $date_retour_prevue);
        $stmt->bindParam(":id_exemplaire", $id_exemplaire);
        $result = $stmt->execute();

        // Mettre l'exemplaire en indisponible
        if ($result) {
            $sql2 = "UPDATE exemplaire SET disponible='non' WHERE id_exemplaire=:id_exemplaire";
            $stmt2 = $this->conn->prepare($sql2);
            $stmt2->bindParam(":id_exemplaire", $id_exemplaire);
            $stmt2->execute();
        }

        return $result;
    }

    // Retourner un livre
    public function retourner($id_emprunt) {
        // Obtenir l'id_exemplaire
        $sql = "SELECT e.id_exemplaire FROM $this->table AS em
                JOIN exemplaire e ON em.id_livre = e.id_livre
                WHERE em.id_emprunt = :id_emprunt LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id_emprunt", $id_emprunt);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$res) return false;

        // Mettre à jour l'emprunt
        $sql2 = "UPDATE $this->table SET date_retour_effective=CURDATE(),
                  statut = CASE WHEN CURDATE() > date_retour_prevue THEN 'en retard' ELSE 'retourné' END
                  WHERE id_emprunt=:id_emprunt";
        $stmt2 = $this->conn->prepare($sql2);
        $stmt2->bindParam(":id_emprunt", $id_emprunt);
        $stmt2->execute();

        // Remettre l'exemplaire disponible
        $sql3 = "UPDATE exemplaire SET disponible='oui' WHERE id_exemplaire=:id_exemplaire";
        $stmt3 = $this->conn->prepare($sql3);
        $stmt3->bindParam(":id_exemplaire", $res['id_exemplaire']);
        $stmt3->execute();

        return true;
    }

    // Lister tous les emprunts (admin) ou ceux du membre
    public function lister($id_utilisateur=null) {
        if ($id_utilisateur) {
            $sql = "SELECT em.*, l.titre, u.nom, u.prenom 
                    FROM $this->table em
                    JOIN livre l ON em.id_livre = l.id_livre
                    JOIN utilisateur u ON em.id_utilisateur = u.id_utilisateur
                    WHERE em.id_utilisateur=:id_utilisateur
                    ORDER BY em.date_emprunt DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":id_utilisateur", $id_utilisateur);
            $stmt->execute();
        } else {
            $sql = "SELECT em.*, l.titre, u.nom, u.prenom 
                    FROM $this->table em
                    JOIN livre l ON em.id_livre = l.id_livre
                    JOIN utilisateur u ON em.id_utilisateur = u.id_utilisateur
                    ORDER BY em.date_emprunt DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
        }
        return $stmt;
    }
}
?>
