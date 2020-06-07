<?php

	require_once 'session.php';

	//Handle Add New Note Ajax Request

	if(isset($_POST['action']) && $_POST['action'] == 'add_note'){
		$title = $cuser->test_input($_POST['title']);
		$note = $cuser->test_input($_POST['note']);

		$cuser->add_new_note($cid, $title, $note);
		$cuser->notification($cid,'admin','Note added');

	}

	//Handle Display All Notes of an User

	if(isset($_POST['action']) && $_POST['action'] == 'display_notes'){
		$output = '';


		$notes = $cuser->get_notes($cid);

		if($notes){
			$output .='
				<table class="table table-stripped  text-center">
    					<thead>
    						<tr>
    							<th>#</th>
    							<th>Title</th>
    							<th>Note</th>
    							<th>Action</th>
    						</tr>
    					</thead>
    					<tbody>';
    				foreach ($notes as $row){
    					$output .= '
    					<tr>
    							<td> '.$row['id']. ' </td>
    							<td> '.$row['title']. ' </td>
    							<td> '.substr($row['note'],0, 75). '...</td>
    							<td>
    								<a href="#" id="'.$row['id'].'" title="View Details" class="text-success infoBtn"><i class="fas fa-info-circle fa-lg"></i></a>&nbsp;

    								<a href="#" id="'.$row['id'].'" title="Edit Note" class="text-primary editBtn"><i class="fas fa-edit fa-lg" data-toggle="modal" data-target="#editNoteModal"></i></a>&nbsp;

    								<a href="#" id="'.$row['id'].'" title="Delete Note" class="text-danger deleteBtn"><i class="fas fa-trash-alt fa-lg"></i></a>
    							</td>
    						</tr>';
    				}
    				$output .= '</tbody></table>';

    				echo $output;
		}
		else
		{
			echo '<h3 class="text-center text-secondary">:( You have not written any note yet! Write your first note now!</h3>';
		}
	}	

	//Handle Edit Note of An User Ajax Request
	if(isset($_POST['edit_id'])){
		$id = $_POST['edit_id'];

		$row = $cuser->edit_note($id);
		echo json_encode($row);
	}

	//Handle Update Note of An User Ajax Request
	if(isset($_POST['action']) && $_POST['action'] == 'update_note'){
		$id = $cuser->test_input($_POST['id']);
		$title = $cuser->test_input($_POST['title']);
		$note = $cuser->test_input($_POST['note']);

		$cuser->update_note($id,$title,$note);
		$cuser->notification($cid,'admin','Note updated');
	}

	//Handle Delete a Note of An user ajax request
	if(isset($_POST['del_id'])){
		$id =$_POST['del_id'];

		$cuser->delete_note($id);
		$cuser->notification($cid,'admin','Note deleted');
	}

	//Handle Display a Note of an user ajax request
	if(isset($_POST['info_id'])){
		$id = $_POST['info_id'];

		$row = $cuser->edit_note($id);

		echo json_encode($row);
	}

	//Handle Profile Update Ajax Request
	if(isset($_FILES['image'])){
		$name =$cuser->test_input($_POST['name']);
		$gender =$cuser->test_input($_POST['gender']);
		$dob =$cuser->test_input($_POST['dob']);
		$phone =$cuser->test_input($_POST['phone']);

		$oldImage = $_POST['oldimage'];
		$folder = 'uploads/';

		if(isset($_FILES['image']['name']) && ($_FILES['image']['name'] != '')){
			$newImage = $folder.$_FILES['image']['name'];
			move_uploaded_file($_FILES['image']['tmp_name'], $newImage);

			if($oldImage != null){
				unlink($oldImage);
			}
		}
		else{
			$newImage = $oldImage;
		}
		$cuser->update_profile($name,$gender,$dob,$phone,$newImage,$cid);
		$cuser->notification($cid,'admin','Profile updated');
		
	}

	//Handle Change Password Ajax Request

	



	//Handle Send Feedback to Admin Ajax Request
	if(isset($_POST['action']) && $_POST['action'] == 'feedback'){
		$subject = $cuser->test_input($_POST['subject']);
		$feedback = $cuser->test_input($_POST['feedback']);

		$cuser->send_feedback($subject,$feedback,$cid);
		$cuser->notification($cid,'admin','Feedback written');
	}

	//Handle Fetch Notification
	if(isset($_POST['action']) && $_POST['action']== 'fetchNotification'){
		$notification = $cuser->fetchNotification($cid);
		$output = '';

		if($notification){
			foreach ($notification as $row) {
				$output .='<div class="alert alert-danger" role="alert">
			    				<button type="button" id="'.$row['id'].'" class="close" data-dismiss="alert" aria-label="close" >
			    					<span aria-hidden="true">&times;</span>
			    				</button>
			    				<h4 class="alert-heading">New Notification</h4>
			    				<p class="mb-0 lead">'.$row['message'].'</p>
			    				<hr class="my-2">
			    				<p class="mb-0 float-left">Reply of feedback from Admin</p>
			    				<p class="mb-0 float-right">'. $cuser->timeInAgo( $row['created_at']).'</p>
			    				<div class="clearfix"></div>
			    			</div>';
			}
			echo $output;
		}
		else{
			echo '<h3 class ="text-center text-secondary mt-5">No any new notification</h3>';
		}
	}

	//Check Notification
	if(isset($_POST['action']) && $_POST['action'] == 'checkNotification'){
		if($cuser->fetchNotification($cid)){
			echo '<i class="fas fa-circle fa-sm text-danger"></i>';
		}
		else{
			echo '';
		}
	}

	//Remove Notification
	if(isset($_POST['notification_id'])){
		$id = $_POST['notification_id'];
		$cuser->removeNotification($id);
	}
	
	
	
	
?>