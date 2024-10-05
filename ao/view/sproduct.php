<?php
    $html_ds_comment_id=show_comment($ds_comment);
    $html_dssp_splq = showsp($dssp_lienquan);
    $html_chitietsp = showchitietsp($spchitiet);
?>
<style>
    body{
    background-color:#e9ebee;
}

.be-comment-block {
    margin-bottom: 50px !important;
    border: 1px solid #edeff2;
    border-radius: 2px;
    padding: 50px 70px;
    border:1px solid #ffffff;
}

.comments-title {
    font-size: 16px;
    color: #262626;
    margin-bottom: 15px;
    font-family: 'Conv_helveticaneuecyr-bold';
}

.be-img-comment {
    width: 60px;
    height: 60px;
    float: left;
    margin-bottom: 15px;
}

.be-ava-comment {
    width: 60px;
    height: 60px;
    border-radius: 50%;
}

.be-comment-content {
    margin-left: 80px;
}

.be-comment-content span {
    display: inline-block;
    width: 49%;
    margin-bottom: 15px;
}

.be-comment-name {
    font-size: 13px;
    font-family: 'Conv_helveticaneuecyr-bold';
}

.be-comment-content a {
    color: #383b43;
}

.be-comment-content span {
    display: inline-block;
    width: 49%;
    margin-bottom: 15px;
}

.be-comment-time {
    text-align: right;
}

.be-comment-time {
    font-size: 11px;
    color: #b4b7c1;
}

.be-comment-text {
    font-size: 13px;
    line-height: 18px;
    color: #7a8192;
    display: block;
    background: #f6f6f7;
    border: 1px solid #edeff2;
    padding: 15px 20px 20px 20px;
}

.form-group.fl_icon .icon {
    position: absolute;
    top: 1px;
    left: 16px;
    width: 48px;
    height: 48px;
    background: #f6f6f7;
    color: #b5b8c2;
    text-align: center;
    line-height: 50px;
    -webkit-border-top-left-radius: 2px;
    -webkit-border-bottom-left-radius: 2px;
    -moz-border-radius-topleft: 2px;
    -moz-border-radius-bottomleft: 2px;
    border-top-left-radius: 2px;
    border-bottom-left-radius: 2px;
}

.form-group .form-input {
    font-size: 13px;
    line-height: 50px;
    font-weight: 400;
    color: #b4b7c1;
    width: 100%;
    height: 50px;
    padding-left: 20px;
    padding-right: 20px;
    border: 1px solid #edeff2;
    border-radius: 3px;
}

.form-group.fl_icon .form-input {
    padding-left: 70px;
}

.form-group textarea.form-input {
    height: 54px;
    width: 952px;
}
</style>

<section id="prodetails" class="section-p1">
    <?=$html_chitietsp?>
</section>

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<div class="container">
    <div class="be-comment-block">
        <?php $count_comment=get_count_comment($id);
            echo '<h1 class="comments-title">Bình Luận ('.$count_comment['soluong_comment'].')</h1>';
        ?>
        <?=$html_ds_comment_id?>
        <form class="form-block" action="index.php?pg=sproduct&id=<?=$id?>" method="post">
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <textarea class="form-input" name="comment" required="" placeholder="<?php if(!is_user_logged_in()){echo 'Bạn cần đăng nhập để bình luận!';}else{echo 'Bình luận dưới tên '.$user_profile['hoten'].'';}?>"></textarea>
                        <button name="send" type="submit" class="btn btn-primary" style="margin-bottom: 46px;padding:14px">Gửi</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

        <section id="product1" class="section-p1">
            <h2>Sản Phẩm Liên Quan</h2>
            <!-- <p>Summer Collection New Morden Design</p> -->
            <div class="pro-container">
                <?=$html_dssp_splq?>
            </div>
        </section>

        <script>
            var MainImg  = document.getElementById("MainImg");
            var smallimg = document.getElementsByClassName("small-img");

            smallimg[0].onclick = function() {
                MainImg.src = smallimg[0].src;
            }
            smallimg[1].onclick = function() {
                MainImg.src = smallimg[1].src;
            }
            smallimg[2].onclick = function() {
                MainImg.src = smallimg[2].src;
            }
            smallimg[3].onclick = function() {
                MainImg.src = smallimg[3].src;
            }
        </script>



