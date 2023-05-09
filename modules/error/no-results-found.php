<?php
// modules/error/not-found.php
?>

<div class="text-center pt-5 px-5">
  <div class="error mx-auto text-gray-800"><i class="fas fa-search fa-fw"></i></div>
  <p class="lead text-gray-800 mb-0">No results found</p>
  <p class="text-gray-500 mb-4">Sorry, we couldn't find what you're looking for...</p>


  <p class="text-gray-700 mb-1">Try a new search term instead</p>

  <form class="mx-auto mb-4" method="POST" action="">
    <div class="row justify-content-center">
      <div class="col-xl-6 col-lg-8 col-md-10 col-sm-12">
        <div class="input-group">
          <input type="text" class="form-control small" placeholder="Search..." aria-label="Search" name="primary_search_text" autofocus required>
          <div class="input-group-append">
            <button class="btn btn-primary" type="submit" name="primary_search_button">
              <i class="fas fa-search fa-sm"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <?php if (isset($_SESSION[alias() . '_user_id'])) : ?>
    <a href="<?php echo uri() . '/' . $_SESSION[alias() . '_active_app']; ?>" title="Go back to dashboard">Go back to Dashboard</a>
  <?php endif; ?>
</div>