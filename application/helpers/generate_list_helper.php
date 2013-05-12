<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('generate_list_comment_helper'))
{
    function generate_list_comment_helper($datalist,$hasVotedArray, $username, $isAdmin)
    {		    	
    	//You may need to load the model if it hasn't been pre-loaded
    	//$CI->load->model('core/my_model');
    	$list = "<ul class='ul-comments-user-list'>";
    	//echo count($datalist);
    	foreach($datalist as $row){    		
			$list .= "<li id='comment-".$row->id."' class='comment-".$row->id." ".(($row->parentCommentId > 0) ? 'child' : '' )."' value='".$row->id."' >";
			$list .= "<a href='/story/display/".$row->storyId."' id='story-link-username-".$row->id."' class='story-link-username'>".$row->storyName."</a> by ";
			$list .= "<a href='/user/".$row->creatorName."' id='story-link-username-".$row->id."' class='story-link-username'>".$row->creatorName."</a>";			
			$list .= " in <a href='/f/".$row->categoryName."' class='story-link-domain comments-user'>".$row->categoryName."<br/>";
			$list .= "<a href='/user/".$row->name."' id='story-link-username-".$row->id."' class='story-link-username'><b>".$row->name."</b></a>";
			$list .= '<a href="javascript:void(0);" id="comment-link-upvote-'.$row->id.'" class="comment-link-upvote fui-plus-24 ';
			if($hasVotedArray[$row->id] == true){
				$list .= "voted";			
			}
			$list .= '" value="'.$row->id.'">&hearts;</a>';						
			$list .= "<label class='comment-post-score'>".$row->score." points</label>";
			$list .= "<label class='story-link-time-ago'>".convert_time_helper($row->days, $row->hours, $row->years, $row->minutes, $row->seconds)."</label><br/>";
			$list .= "<div id='comment-container-".$row->parentCommentId."' class='comment-container'>";				
			$list .= "<label class='comment-post'>".htmlentities($row->comment)."</label><br/>";			
			

			$list .= "<a class='comment-delete-btn-profile' id='story-link-comments-count-".$row->id."' href='/story/display/".$row->storyId."'>link</a> | ";
			if($row->name == $username || $isAdmin == 'true'){				
				$list .= "<a href='/comment/delete/".$row->id."/false' id='comment-delete-".$row->id."' class='comment-delete-btn-profile' value='".$row->id."' value='".$row->id."'>delete</a>";
			}

			$list .= "</div>";				
			$list .= "</li>";
    	}

		$list .= '</ul>';
		return $list;
	}
	
}


if ( ! function_exists('generate_list_submit_helper'))
{
    function generate_list_submit_helper($datalist,$hasVotedArray, $username, $isAdmin)
    {		
    	//You may need to load the model if it hasn't been pre-loaded
    	//$CI->load->model('core/my_model');
    	$list = "<ul class='ul-comments-user-list'>";
    	//echo count($datalist);
    	foreach($datalist as $row){    		

			$list .="<li id='story-entry-".$row->id."' class='story-entry'>";				
			$link = $row->link;
			$score = $row->score;
			$domain = $row->domain;

			if($score === null){$score = 0;}			
			
			if(strlen($row->link) > 0){
				$list .="<a id='story-link-".$row->id."' class='story-link' href='".$row->link."'>";
			}else{
				$list .="<a id='story-link-".$row->id."' class='story-link' href='/story/display/".$row->id."'>";
			}
			$list .= $row->title;
			$list .="</a>";
			$list .="<a href='javascript:void(0);' id='story-link-upvote-".$row->id."' class='story-link-upvote fui-plus-24 ";

			//check if voted for stories
			if($hasVotedArray[$row->id] == true){
				$list .= "voted";			
			}

			$list .= "' value='".$row->id."'>&hearts;</a>";
			if(strlen($domain) > 0){
				$list .="<a href='http://".$row->domain."' class='story-link-domain'>(".$domain.")</a>";
			}else{
				$list .="<a href='/f/".$row->categoryname."' class='story-link-domain'>(self.".$row->categoryname.")</a>";
			}

			$list .="<br/><label class='story-link-score'>".$score." points</label>";
			$list .="<label class='story-link-by'>by</label>";
			$list .="<a href='/user/".$row->name."' id='story-link-username-".$row->id."' class='story-link-username'>".$row->name."</a>";
			$list .="<label class='story-link-time-ago'>".convert_time_helper($row->days, $row->hours, $row->years, $row->minutes, $row->seconds)."</label>";
			$list .="<label class='story-link-to'>to</label>";
			$list .="<a href='/f/".$row->categoryname."' class='story-link-categoryname'>".$row->categoryname."</a> | ";
			$list .="<a class='story-link-comments-count' id='story-link-comments-count-".$row->id."' href='/story/display/".$row->id."'>0 comments</a>";
			if($username == $row->name || $isAdmin == "true"){
				$list .=" | <a href='/story/delete/".$row->id."/false' id='story-delete-".$row->id."' class='story-delete-btn' value='".$row->id."' value='".$row->id."'>delete</a>";
			}				
			$list .="</li>";


    	}

		$list .= '</ul>';
		return $list;
	}
	
}