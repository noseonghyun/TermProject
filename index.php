<script src = "http://code.jquery.com/jquery-3.2.1.js"></script>

<html>
	<head>
		<title></title>
    <link rel="stylesheet" href = "style.css">
	<?php
	require "conn.php";

	if(!isset($_GET['category']))
	{
		$sql = "select * from popup limit 0,2";
		$result = mysqli_query($connect, $sql);
		$arr = mysqli_fetch_all($result, MYSQLI_ASSOC);
		$rows = mysqli_num_rows($result);

		for($i = 0; $i < $rows; $i++)
		{
			$mytime = mktime($arr[$i]['time4'],$arr[$i]['time5'],$arr[$i]['time6'],$arr[$i]['time2'],$arr[$i]['time3'],$arr[$i]['time1']);
			$nontime = mktime();

			if($arr[$i]['choice'] == 'y' && ($mytime > $nontime))
			{
			?>
				<script language = "JavaScript">
					window.open("popup.php?id=<?=$i?>","popup<?=$i?>","seoropop<?=$i?>','toolbar = no, location = no, directories = no, status = no, menubar = no, scrollbars = auto, resizable = no, width = 320, height = 300");
				</script>
			<?php
			}
		}
	}
	?>
	</head>
	<body>
    <?php
		

		require "header.php";
		/*조회수 올려주기*/
		$sql = "update board set hit = hit+1 where no = {$row['no']}";
		mysqli_query($connect,$sql);
		?>
    <div class = "right_menu f_right">
			<?php
				/*선택한 카테고리의 값이 없다면*/
					if($row['category'] == "")
					{
						?>
						<div class = "center b_font">
							작성된 글 내용이 없습니다.
						</div>
						<?php
						mysqli_close($connect);
						exit;
					}
					$page_in_date = 3;
					$block_in_page = 5;

					if(isset($_GET['now_page']))
					{
						if($_GET['now_page'])
						{
							$now_page = $_GET['now_page'];
						}
						else
						{
							$now_page = 1;
						}
					}
					else
					{
						/*최초접속시 페이지 1로 초기화*/
						$now_page = 1;
					}

					/*SQL LIMIT 구문에서 사용할 변수*/
					$limit_start = ($now_page-1)*$page_in_date;

					/*게시판형일때와 엘범형일때의 다른 쿼리구문*/
					if(!$cur_cate['album'])
					{
				  	$sql4 = "select * from board where category = {$row['category']} limit $limit_start,$page_in_date";
					}
					else
					{
						$sql4 = "select * from board where category = {$row['category']}";
					}

					$result4 = mysqli_query($connect,$sql4);
				  $arr4 = mysqli_fetch_all($result4,MYSQLI_ASSOC);
				  $rows4 = mysqli_num_rows($result4);

					/*게시판형일때와 엘범형일때의 다른 본문*/
					if(!$cur_cate['album'])
					{
						require "board_type.php";
					}
					else
					{
						require "album_type.php";
					}
			?>
			</div>
	</body>
</html>
<?php
mysqli_free_result($result);
mysqli_free_result($result3);
mysqli_close($connect);
?>
