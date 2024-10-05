<?php
session_start();
ob_start();

include "dao/pdo.php";
include "dao/user.php";
include "dao/bill.php";
include "dao/comment.php";
include "dao/check.php";
include "dao/danhmuc.php";
include "dao/sanpham.php";
include "dao/giohang.php";
include "view/header.php";

$is_user_logged_in = is_user_logged_in();
$dssp_new = get_dssp_new(4);
// $dssp_best = get_dssp_best(4);
$dssp_view = get_dssp_view(4);
$html_dssp_current_category = showsp(7);
$dssp_luotmua = get_dssp_luotmua(4);

if (!isset($_GET['pg'])) {
    include "view/home.php";
} else {
    switch ($_GET['pg']) {
        case 'blog':
            include "view/blog.php";
            break;
        case 'about':
            include "view/about.php";
            break;
        case 'contact':
            include "view/contact.php";
            break;
        case 'checkout':
            include "view/checkout.php";
            break;
        case 'dhthanhcong':
            if (isset($_POST['thanhtoan'])) {
                $ten = $_POST['nguoinhan_ten'];
                $diachi = $_POST['nguoinhan_diachi'];
                $sdt = $_POST['nguoinhan_sdt'];
                $email = $_POST['nguoinhan_email'];
                $pt_thanhtoan = $_POST['selector'];
                $tongtien = $_POST['tongtien'];
                $notes = $_POST['order_notes'];
                $id_user = $_SESSION['id_user'];
                srand(time());
                $madonhang = 'YM-' . rand();
                add_bill($id_user, $madonhang, $ten, $diachi, $sdt, $email, $pt_thanhtoan, $tongtien, $notes);
                $id_bill = get_id_bill();
                $id = $id_bill['id'];
                if ($id != '') {
                    add_bill_chitiet($id, $id_user);
                    delete_cart_user($id_user);
                    header('location: index.php?pg=dhthanhcong');
                }
            }
            include "view/dhthanhcong.php";
            break;
        case 'cart':
            if (isset($_POST['cart'])) {
                $product_id = $_POST['id'];
                $product_name = $_POST['name'];
                $product_img = $_POST['img'];
                $product_price = $_POST['price'];
                $product_quantity = $_POST['soluong'];
                $thanhtien = $product_price * $product_quantity;

                if (!$is_user_logged_in) {
                    echo '<script>alert("Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng.");</script>';
                    echo '<script>window.location.href = "index.php?pg=dangnhap";</script>';
                    exit;
                } else {
                    $id_user = $_SESSION['id_user'];
                }

                $cart = get_cart_product($product_id, $id_user);
                $id_cart = $cart['id_product'];
                $user_cart = $cart['id_user'];

                if ($id_cart == $product_id && $user_cart == $id_user) {
                    $up_quantity = $cart['soluong'] + $_POST['soluong'];
                    $up_thanhtien = $up_quantity * $product_price;
                    updates_cart($product_id, $up_quantity, $up_thanhtien, $id_user);
                } else {
                    addcart($product_id, $id_user, $product_name, $product_img, $product_price, $product_quantity, $thanhtien);
                }

                header('Location: index.php?pg=cart');
            }

            include "view/cart.php";
            break;
            case 'order':
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_status'])) {
                    $bill_id = $_POST['bill_id'];
                    $new_status = $_POST['new_status'];
                    if (in_array($new_status, [1, 2, 3, 4, 5])) {
                        update_bill_status($bill_id, $new_status);
                    } else {
                        echo 'Trạng thái không hợp lệ';
                    }
                }
                $ds_bill = get_all_bill(0);
                $html_ds_bill = show_bill_admin($ds_bill);
                include "view/order.php";
                break;
        case 'cancel_order':
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bill_id'])) {
                $billId = $_POST['bill_id'];
                $success = cancel_order($billId);
        
                if ($success) {
                    echo 'success';
                } else {
                    echo 'error';
                }
            } else {
                echo 'invalid_request';
            }
            break;
        case 'dangky':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $hoten = $_POST['hoten'];
                $email = $_POST['email'];
                $dienthoai = $_POST['dienthoai'];
                $username = $_POST['username'];
                $password = $_POST['password'];
                $register_result = register_user($hoten, $email, $dienthoai, $username, $password);
                if ($register_result === true) {
                    echo '<p style="color: green;">Đăng ký thành công! Đăng nhập <a href="index.php?pg=dangnhap">tại đây</a>.</p>';
                } else {
                    echo '<p style="color: red;">Đăng ký thất bại: ' . $register_result . '</p>';
                }
            }
            include "view/dangky.php";
            break;
            case 'dangnhap':
                if ($is_user_logged_in) {
                    header("Location: index.php");
                    exit();
                }
                $checkMK = 0; 
                $saimatkhau = ''; 
                $saitaikhoan = ''; 
            
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (isset($_POST['username']) && isset($_POST['password'])) {
                        $username = $_POST['username'];
                        $password = $_POST['password'];
                        $user = get_user_by_username($username);
                        if ($user) {
                            $id_user = $user['id'];
                            $_SESSION['name'] = $username;
                            $_SESSION['id_user'] = $id_user;
                            $login_result = login_user($username, $password);
                            if ($login_result) {
                                $_SESSION['user_id'] = $login_result;
                                if (isset($_SESSION['is_admin']) && ($_SESSION['is_admin'] == 1)) {
                                    echo '<center><p style="color: green;">Đăng nhập thành công!</p></center>';
                                    header("Location: admin/index.php");
                                } else {
                                    echo '<center><p style="color: green;">Đăng nhập thành công!</p></center>';
                                    header("Location: index.php");
                                }
                                exit();
                            } else {
                                $checkMK = 1;
                                $saimatkhau = '<p style="color: red;">Đăng nhập thất bại: sai mật khẩu</p>';
                            }
                        } else {
                            $checkMK = 2;
                            $saitaikhoan = '<p style="color: red;">Tên đăng nhập không tồn tại!</p>';
                        }
                    } else {
                        echo '<center><p style="color: red;">Thiếu thông tin đăng nhập!</p></center>';
                    }
                }
                include "view/dangnhap.php";
                break;
            
        case 'dangxuat':
            if ($is_user_logged_in) {
                session_unset();
                session_destroy();
                header("Location: index.php");
                exit();
            }
            break;
        case 'shop':
            $dsdm = danhmuc_all();
            $kyw = "";
            $titlepage = "";
            $sethome = "";

            if (!isset($_GET['iddm'])) {
                $iddm = 0;
            } else {
                $iddm = $_GET['iddm'];
                $titlepage = get_name_dm($iddm);
                $sethome = get_sethome_dm($iddm);
            }

            if (isset($_POST["timkiem"]) && ($_POST["timkiem"])) {
                $kyw = $_POST["kyw"];
                $titlepage = "Kết quả tìm kiếm với từ khóa: <span>" . $kyw . "</span>";
            }

            $dssp = get_dssp($kyw, $iddm, 11, $sethome);
            include "view/shop.php";
            break;
        case 'sproduct':
            $dsdm = danhmuc_all();

            if (isset($_GET["id"]) && ($_GET["id"] > 0)) {
                $id = $_GET["id"];
                $view = get_sp_view($id);
                $upview = (int)$view + 1;
                updates_view_sanpham($id, $upview);
                $iddm = get_iddm($id);
                $dssp_lienquan = get_dssp_lienquan($iddm, $id, 4);
                $spchitiet = get_sproduct($id);

                if (is_user_logged_in()) {
                    $id_user = $_SESSION['id_user'];
                }

                $ds_comment = get_all_comment_id_sampham($id);

                if (isset($_POST['send']) && $_POST['comment'] != '') {
                    if (!is_user_logged_in()) {
                        header('location: index.php?pg=dangnhap');
                    } else {
                        $id_user = $_SESSION['id_user'];
                        $comment = $_POST['comment'];
                        $ngay_bl = date('H:i:s d/m/Y');
                        comment($id, $id_user, $comment, $ngay_bl);
                        header("Location: index.php?pg=sproduct&id=$id");
                    }
                }

                include "view/sproduct.php";
            } else {
                include "view/home.php";
            }
            break;
        case 'profile_user':
            if (isset($_POST['submit'])) {
                $id = $_POST['id'];
                $hoten = $_POST['hoten'];
                $sdt = $_POST['number-phone'];
                $email = $_POST['email'];
                $diachi = $_POST['address'];
                $oldpass = $_POST['oldpass'];
                $newpass = $_POST['newpass'];
                $user = get_user_by_id($id);

                if (password_verify($oldpass, $user['password'])) {
                    $newpass_hash = password_hash($newpass, PASSWORD_BCRYPT);
                    update_password($id, $newpass_hash);
                }

                update_user($id, $hoten, $sdt, $diachi, $email);
                header("location: index.php?pg=profile_user&act=user_updates");
            }

            include "view/profile_user.php";
            break;
        case 'forgot_password':
            include "view/forgot_password.php";
            break;
        case 'voucher':
            include "view/voucher.php";
            break;
        default:
            include "view/home.php";
            break;
    }
}

include "view/footer.php";
?>
