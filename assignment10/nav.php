<!-- ######################     Main Navigation   ########################## -->
<nav>
  <ol>
    <?php
	    // This sets the current page to not be a link. Repeat this if block for
	    //  each menu item 
	    if ($path_parts['filename'] == "index") {
	        print '<li class="activePage">Pantry</li>';
	    } else {
	        print '<li><a href="index.php">Pantry</a></li>';
	    }
	    if ($path_parts['filename'] == "about") {
	        print '<li class="activePage">About</li>';
	    } else {
	        print '<li><a href="about.php">About</a></li>';
	    }
	    if ($path_parts['filename'] == "restock") {
	        print '<li class="activePage">(re)Stock</li>';
	    } else {
	        print '<li><a href="restock.php">(re)Stock</a></li>';
	    }
	    if ($path_parts['filename'] == "use") {
	        print '<li class="activePage">Receipe(WIP)</li>';
	    } else {
	        print '<li><a href="use.php">Receipe(WIP)</a></li>';
	    }
	    if ($path_parts['filename'] == "account") {
	        print '<li class="activePage">Account</li>';
	    } else {
	        print '<li><a href="account.php">Account</a></li>';
	    }
	    if ($userData['admin']) {
	    	if ($path_parts['filename'] == "admin") {
	          print '<li class="activePage">Admin</li>';
	      } else {
	          print '<li><a href="admin.php">Admin</a></li>';
	      }
	    }
    ?>
  </ol>
</nav>
<!-- #################### Ends Main Navigation    ########################## -->
