  </div> <!-- Fin du container -->

  <!-- Pied de page -->
  <footer class="footer">
      <div class="container">
          <p>&copy; <?php echo date('Y'); ?> <?php echo APP_NAME; ?> - Projet pédagogique RNCP</p>
          <small>Structure organisée en PHP procédural avec PDO sécurisé</small>
      </div>
  </footer>

  <!-- Scripts Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
      // Fonction pour confirmer la suppression
      function confirmerSuppression(nom, prenom) {
          return confirm('Êtes-vous sûr de vouloir supprimer le contact ' + nom + ' ' + prenom + ' ?');
      }

      // Auto-masquer les alertes après 5 secondes
      setTimeout(function() {
          var alertes = document.querySelectorAll('.alert');
          alertes.forEach(function(alerte) {
              var bsAlert = new bootstrap.Alert(alerte);
              bsAlert.close();
          });
      }, 5000);
  </script>
  </body>

  </html>