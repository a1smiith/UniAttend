<?php

if (!isset($_SERVER['HTTPS']) || !$_SERVER['HTTPS']) { // if request is not secure, redirect to secure url
    $url = 'https://' . $_SERVER['HTTP_HOST']
                      . $_SERVER['REQUEST_URI'];

    header('Location: ' . $url);
    exit;
}

	$link = $url = '';
	$linkErr = '';

	if( ($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST['submit']) ):

		if(empty($_POST["link"])):
			$linkErr = "من فضلك ضع الرابط";

		else:
			$link = test_input($_POST["link"]);

			// check if URL address syntax is valid (this regular expression also allows dashes in the URL)
			if(!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$link)):
				$linkErr = "من فضلك ضع رابط صحيح";

			else: 
				$link_info = parse_url($link);
				
				if(isset($link_info['query'])):
					parse_str(html_entity_decode($link_info['query']),$output);

					if(!isset($output["course_id"]) || empty($output["course_id"])):
						$linkErr = "يجب أن يحتوي الرابط على ";
						$linkErr .= "course_id";

					else:
						$url = $link_info['scheme']."://".$link_info['host']."/webapps/attendance/myGradesAttendance?course_id=";
						$url .= $output["course_id"];

					endif;

				else: 
					$linkErr = "من فضلك ضع رابط يحتوي علي المعلومات الصحيحة";

				endif;

			endif;
	
		endif;
		
	endif;

	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

?>

<!DOCTYPE html>
<html lang="ar">
	<head>


		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>سجل الحضور</title>
		<link rel="stylesheet" href="css/stylesheet.css">

<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Almarai:wght@700&family=Cairo:wght@600;700&family=Lalezar&family=Lateef&display=swap" rel="stylesheet">

	
	</head>

	<body style="text-align: center;">


	<nav>
  <a style="text-decoration: underline; font-family: 'Almarai', sans-serif; font-size: 12.5px" href="https://uniattend.net/howto.html">طريقة الاستخدام</a>
   <a style="text-decoration: underline; font-family: 'Almarai', sans-serif; font-size: 12.5px;" href="https://uniattend.net">الرئيسية</a>
</nav>

		<main style="margin-bottom: 0; margin-top: 350px;  flex: 50;
">

			<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">


				<div class="body">
					
					 <h4 style="color: #8d2645;
	
	font-family: 'Almarai', sans-serif;
	font-size: 18px;
     height: 100%;
     margin-top: -250px;
     margin-bottom: -10px;
     ">«هام جداً»

				</h4>


     	<h5 style="color: red;
		font-weight: 800;
		font-size: 12.5px;


     height: 100%;
     margin-top: -50px;
     padding-bottom: 20px;
     padding-top: 0;
     margin-bottom: 60px"></br>course_id علماً أن الموقع يقوم بنسخ كود المادة المشار إليه بـ </br>ووضعه على رابط الغياب الرسمي الخاص بالبلاك بورد </br> الموقع تمت برمجته على كود بسيط فقط ولا يطلب اي معلومات شخصية </br> وأي مبرمج ومطور او طالب حاسب سيعرف كيفية عمل الموقع</h5>


    


					<h2 style="color:#6f614b; font-size: 24px;line-height: 0.75em; font-family: 'Almarai', sans-serif;"><span>: ضع رابط المادة</span></h2>

					<div class="wrapper">
						<input class="search" type="text" name="link"/>
						</br>
					</br>

						<input class="submit" name="submit" type="submit" value="تأكيد" />

					</div>

<h5 style="margin-top: 80px; margin-bottom: 10px; color:#ba2d58; font-size: 11.5px;">الموقع آمن 100% ولايتم فيه جمع أي معلومات</h5>



					<?php if(!empty($linkErr)): ?>
					<span class="error"> <?php echo $linkErr;?></span>
					<?php endif; ?>
						
					<?php if(!empty($url)): ?>
						<a class="btn" target="_blank" href="<?php echo $url;?>">مشاهدة سجل الحضور</a> <!--<h3 style="color: white; position: relative; top: 120px">اضغط لمشاهدة سجل الحضور</h3> --> 
						
					<?php endif; ?>
</br>
</br>


					<footer class="footer">
	<h6> جميع الحقوق محفوظة</h6>
</footer>

				</div>

		<!--		<h2>اضغط لمشاهدة سجل الحضور</h2> -->

			</form>



		
		
		</main>

	</body>
</html>	