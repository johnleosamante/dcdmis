<?php
session_start();
$_SESSION['MyNo']=$_GET['code'];
?>
        <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4>Leave Details </h4>
        </div>
        <div class="modal-body">
          <form action="update_request.php" Method="POST">
		  <?php
		 echo $_SESSION['MyNo'];
		  ?>
		   <label>With / Without Pay</label>
		   <select name="payment" class="form-control" required>
		   <option value="-">--Select--</option>
		   <option value="With">With Pay</option>
		   <option value="Without">Without Pay</option>
		   </select>
		   <label>Reason for Leaved</label>
		   <input type="text" name="reason_for_leave" class="form-control" required>
		   <hr/>
		   <input type="submit" name="submit" value="Submit" class="btn btn-primary">
		  </form>
      </div>
    </div>
