<?php include("crud-header.php") ?>

  <main class="main">
    <!-- Starter Section Section -->
    <section id="menu" class="menu section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2><?php if(isset($error)) { echo $error; } ?></span></p></h2>
        <p><span>Houses</span></p>
        <div class="text-center mt-3">
        <a href="add-dwelling" class="btn btn-danger">Add a dwelling</a>
        </div>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="tab-content" data-aos="fade-up" data-aos-delay="200">

          <div class="tab-pane fade active show" id="menu-starters">
            <div class="row gy-5" id="habitation-list">
              
            </div>
          </div><!-- End Starter Menu Content -->

        </div>
        <script>
          document.addEventListener("DOMContentLoaded", displayList);
        </script>

      </div>

    </section><!-- /Menu Section -->


  </main>

<?php include("footer.php") ?>