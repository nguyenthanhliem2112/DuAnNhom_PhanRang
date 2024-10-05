<?php
require_once 'pdo.php';

function add_sanpham($categories,$product_code,$ten_sp,$gia,$gia_giam,$img,$img1,$img2,$img3,$date,$mota,$special,$view){
    $sql = "INSERT INTO sanpham (id_catalog, ma_sp, ten_sp, gia, giam_gia, hinh, hinh1, hinh2, hinh3, ngay_nhap, mo_ta, dac_biet, so_luot_xem) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?);";
    return pdo_execute($sql,$categories,$product_code,$ten_sp,$gia,$gia_giam,$img,$img1,$img2,$img3,$date,$mota,$special,$view);
}

function updates_sanpham($id,$categories,$product_code,$ten_sp,$gia,$gia_giam,$img,$img1,$img2,$img3,$date,$mota,$special){
    $sql = "UPDATE sanpham SET id=?, id_catalog=?, ma_sp=?, ten_sp=?, gia=?,  giam_gia=?,  hinh=?,  hinh1=?,  hinh2=?,  hinh3=?,  ngay_nhap=?,  mo_ta=?,  dac_biet=? WHERE id=".$id;
    return pdo_execute($sql,$id,$categories,$product_code,$ten_sp,$gia,$gia_giam,$img,$img1,$img2,$img3,$date,$mota,$special);
}

function updates_view_sanpham($id,$upview){
    $sql = "UPDATE sanpham SET id=?,so_luot_xem=? WHERE id=".$id;
    return pdo_execute($sql,$id,$upview);
}

function delete_sanpham($id){
    $sql = 'DELETE FROM sanpham WHERE id= ?;';
    return pdo_execute($sql,$id);
}
// lượt mua
function get_soluong_sp(){
    $sql = "SELECT COUNT(id) FROM sanpham WHERE 1";
    $count = pdo_query_value($sql);
    return $count;
}
function get_dssp_LuotMua($limit){
    $sql = "SELECT *, 
            (SELECT COUNT(*) FROM billchitiet WHERE billchitiet.id_product = sp.id) as luot_mua,
            sp.id, sp.id_catalog, dm.ten_loai 
            FROM sanpham sp 
            INNER JOIN danhmuc dm ON sp.id_catalog = dm.id  
            ORDER BY luot_mua DESC, sp.id DESC LIMIT " . $limit;
    return pdo_query($sql);
}

function get_dssp_new($limit){
    $sql = "SELECT  sp.id, ten_loai, hinh, sp.gia, sp.giam_gia, sp.so_luot_xem, sp.ten_sp 
            FROM sanpham sp 
            INNER JOIN danhmuc dm ON sp.id_catalog = dm.id 
            WHERE sp.ngay_nhap 
            ORDER BY sp.ngay_nhap DESC LIMIT ".$limit;
    return pdo_query($sql);
}

// function get_dssp_best($limit){
//     $sql = "SELECT  *, sp.id as idsp, sp.name as namesp, dm.name as namedm 
//             FROM sanpham sp 
//             LEFT JOIN danhmuc dm ON sp.id_catalog = dm.id 
//             WHERE sp.dac_biet = 1 
//             ORDER BY sp.id DESC LIMIT ".$limit;
//     return pdo_query($sql);
// }
function get_dssp_best_2($limit){
    $sql = "SELECT  * FROM sanpham WHERE dac_biet = 1 
            ORDER BY id DESC LIMIT ".$limit;
    return pdo_query($sql);
}

function get_dssp_view($limit){
    $sql = "SELECT  *, sp.id, dm.ten_loai 
            FROM sanpham sp 
            INNER JOIN danhmuc dm ON sp.id_catalog = dm.id 
            WHERE sp.so_luot_xem 
            ORDER BY sp.so_luot_xem DESC, sp.id DESC LIMIT ".$limit;
    return pdo_query($sql);
}


function get_dssp_all(){
    $sql = "SELECT  *, sp.id, sp.id_catalog, dm.ten_loai FROM sanpham  INNER JOIN danhmuc dm ON sanpham.id_catalog = dm.id WHERE 1";
    return pdo_query($sql);
}

function get_dssp($keyword, $categoryId, $limit,$sethome){
    $sql = "SELECT  *,sp.id, dm.ten_loai FROM sanpham sp INNER JOIN danhmuc dm ON sp.id_catalog = dm.id WHERE 1";

    if($categoryId > 0){
        if($sethome==1){
            $sql .=" AND sp.dac_biet=".$sethome;
        }else{
            $sql .=" AND sp.id_catalog=".$categoryId;
        }
    }
    if($keyword != ""){
        $sql .=" AND sp.ten_sp like '%".$keyword."%'";
    }

    $sql .= " ORDER BY sp.id DESC LIMIT ".$limit;
    return pdo_query($sql);
}


function get_dssp_admin(){
    $sql = "SELECT * FROM sanpham";
    return pdo_query($sql);
}

function get_sp_view($id) {
    $sql = "SELECT so_luot_xem FROM sanpham WHERE id=?";
    return pdo_query_value($sql, $id);
}

function get_sp_id($id) {
    $sql = "SELECT * FROM sanpham WHERE id=?";
    return pdo_query($sql, $id);
}
function get_sproduct($id){
    $sql = "SELECT *,sanpham.id,dm.ten_loai FROM sanpham INNER JOIN danhmuc dm ON sanpham.id_catalog = dm.id  WHERE sanpham.id=?";
    return pdo_query_one($sql, $id);
}

function get_dssp_lienquan($categoryId, $id, $limit){
    $sql = "SELECT * ,sanpham.id,dm.ten_loai FROM sanpham INNER JOIN danhmuc dm ON sanpham.id_catalog = dm.id  WHERE sanpham.id_catalog=? AND sanpham.id<>? ORDER BY sanpham.id DESC LIMIT ".$limit;
    return pdo_query($sql, $categoryId, $id);
}

function get_iddm($id){
    $sql = "SELECT id_catalog FROM sanpham WHERE id=?";
    return pdo_query_value($sql, $id);
}

function searchProducts($keyword, $categoryId, $limit) {
    $sql = "SELECT * FROM sanpham WHERE (ten_sp LIKE :keyword OR mo_ta LIKE :keyword)";
    if ($categoryId != 0) {
        $sql .= " AND id_catalog = :categoryId";
    }

    $sql .= " LIMIT :limit";

    $params = [
        ':keyword' => '%' . $keyword . '%',
        ':limit' => $limit,
    ];

    if ($categoryId != 0) {
        $params[':categoryId'] = $categoryId;
    }

    return pdo_query($sql, $params);
}

function getPopularCategories() {
    $sql = "SELECT id, ten_loai FROM danhmuc ORDER BY stt DESC LIMIT 5";
    return pdo_query($sql);
}
function showsp($dssp) {
    $html_dssp = '';

    if (is_array($dssp) && count($dssp) > 0) {
        foreach ($dssp as $sp) {
            $specialText = '';

            if (isset($sp['dac_biet'])) {
                if ($sp['dac_biet'] == 1) {
                    $specialText = 'HOT';
                } else if ($sp['dac_biet'] == 2) {
                    $specialText = 'NEW';
                }
            }

            $html_dssp .= '<div class="pro' . (isset($sp['dac_biet']) ? ' special' : '') . '">
                              <a href="index.php?pg=sproduct&id=' . $sp['id'] . '">
                                  <img src="layout/img/products/' . $sp['hinh'] . '" alt="" height="380px;">
                                  ' . ($specialText ? '<div class="special-text">' . $specialText . '</div>' : '') . '
                              </a>
                              <div class="des">
                                  ' . (isset($sp['so_luot_xem']) ? '<div class="views"><i class="fas fa-eye"></i> ' . $sp['so_luot_xem'] . '</div>' : '') . '
                                  <a href="index.php?pg=sproduct&id=' . $sp['id'] . '">
                                      <h5>' . $sp['ten_sp'] . '</h5>
                                  </a>
                                  <div class="star">
                                      <i class="fas fa-star"></i>
                                      <i class="fas fa-star"></i>
                                      <i class="fas fa-star"></i>
                                      <i class="fas fa-star"></i>
                                      <i class="fas fa-star"></i>
                                  </div>
                                  <h4>' . number_format($sp['gia']) . ' VNĐ   ' . (isset($sp['gia_giam']) ? $sp['gia_giam'] : '') . ' </h4>
                              </div>
                              <form method="post" action="index.php?pg=cart">
                                <input type="hidden" name="pg" value="cart">
                                <input type="hidden" name="id" value="' . $sp['id'] . '">
                                <input type="hidden" name="name" value="' . $sp['ten_sp'] . '">
                                <input type="hidden" name="img" value="' . $sp['hinh'] . '">
                                <input type="hidden" name="price" value="' . $sp['gia'] . '">
                                <input type="hidden" name="soluong" value="1">
                                <button type="submit" name="cart" class="cart"><i class="fal fa-shopping-cart"></i></button>
                              </form>
                          </div>';
        }
    }

    return $html_dssp;
}

function showchitietsp($sp) {
    $html_chitietsp = '';
    extract($sp);
    $html_chitietsp .= '<div class="single-pro-image">
                            <img src="layout/img/products/'.$hinh.'" width="100%" height="650px" id="MainImg" alt="" style="border:1px solid black;">
                            <div class="small-img-group" style="margin-top:5px;">
                                <div class="small-img-col">
                                    <img src="layout/img/products/'. $hinh .'" width="100%" class="small-img" alt="" height="170px" style="border:1px solid black;">
                                </div>
                                <div class="small-img-col">
                                    <img src="layout/img/products/'. $hinh1 .'" width="100%" class="small-img" alt="" height="170px" style="border:1px solid black;">
                                </div>
                                <div class="small-img-col">
                                    <img src="layout/img/products/'. $hinh2 .'" width="100%" class="small-img" alt="" height="170px" style="border:1px solid black;">
                                </div>
                                <div class="small-img-col">
                                    <img src="layout/img/products/'. $hinh3 .'" width="100%" class="small-img" alt="" height="170px" style="border:1px solid black;">
                                </div>
                            </div>
                        </div>

                        <div class="single-pro-details">
                            <h6>Home / ' . $ten_loai . '</h6>
                            <h3 style="font-size:40px">'. $ten_sp .'</h3>
                            <h2>'. number_format($gia) .' VNĐ</h2>
                            
                            <form method="post" action="index.php?pg=cart" onsubmit="return validateQuantity()">
                                <input type="hidden" name="pg" value="cart">
                                <input type="hidden" name="id" value="' . $id . '">
                                <input type="hidden" name="name" value="' . $ten_sp . '">
                                <input type="hidden" name="img" value="'. $hinh .'">
                                <input type="hidden" name="price" value="'. $gia .'">
                                <input type="number" name="soluong" id="soluong" value="1" min="1">
                                <button class="normal" type="submit" name="cart">Thêm Vào Giỏ Hàng</button>
                            </form>
                            <h4>THÔNG TIN SẢN PHẨM</h4>
                            <span>'. $mo_ta .'
                            </span>
                        </div>
                        <script>
                            function validateQuantity() {
                                var quantity = document.getElementById("soluong").value;
                                if (quantity < 1) {
                                    alert("Số lượng phải lớn hơn hoặc bằng 1.");
                                    return false;
                                }
                                return true;
                            }
                        </script>';
    return $html_chitietsp;
}


function showluotmua($dssp_luotmua) {
    $html_dssp_luotmua = '';

    if (is_array($dssp_luotmua) && count($dssp_luotmua) > 0) {
        foreach ($dssp_luotmua as $sp) {
            $specialText = '';

            if (isset($sp['dac_biet'])) {
                if ($sp['dac_biet'] == 1) {
                    $specialText = 'HOT';
                } elseif ($sp['dac_biet'] == 2) {
                    $specialText = 'NEW';
                }
            }

            $html_dssp_luotmua .= '<div class="pro' . (isset($sp['dac_biet']) ? ' special' : '') . '">
                                    <a href="index.php?pg=sproduct&id=' . $sp['id'] . '">
                                        <img src="layout/img/products/' . $sp['hinh'] . '" alt="">
                                        ' . ($specialText ? '<div class="special-text">' . $specialText . '</div>' : '') . '
                                    </a>
                                    <h6><a href="index.php?pg=sproduct&id=' . $sp['id'] . '"></a></h6>
                                    <div class="des">
                                        <span>' . $sp['ten_loai'] . '</span>
                                        ' . (isset($sp['so_luot_xem']) ? '<div class="views"><i class="fas fa-eye"></i> ' . $sp['so_luot_xem'] . '</div>' : '') . '
                                        <a href="index.php?pg=sproduct&id=' . $sp['id'] . '">
                                            <h5>' . $sp['ten_sp'] . '</h5>
                                            
                                        </a>
                                        <div class="star">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <h4>' . number_format($sp['gia']) . ' VNĐ</h4>
                                    </div>
                                    <form method="post" action="index.php?pg=cart">
                                        <input type="hidden" name="pg" value="cart">
                                        <input type="hidden" name="id" value="' . $sp['id'] . '">
                                        <input type="hidden" name="name" value="' . $sp['ten_sp'] . '">
                                        <input type="hidden" name="img" value="' . $sp['hinh'] . '">
                                        <input type="hidden" name="price" value="' . $sp['gia'] . '">
                                        <input type="hidden" name="soluong" value="1">
                                        <button type="submit" name="cart" class="cart"><i class="fal fa-shopping-cart"></i></button>
                                    </form>
                                </div>';
        }
    }

    return $html_dssp_luotmua;
}




function show_sp_admin($dssp){
    $html_dssp_admin = '';
    $i = 0;
    foreach ($dssp as $item){
        $i++;
        $html_dssp_admin .= '<tr>
                                <td>'.$i.'</td>
                                <td><img src="../layout/img/products/'.$item['hinh'].'" alt="" width="82px"></td>
                                <td>'.$item['ten_sp'].'</td>
                                <td>'.number_format($item['gia']).' VNĐ</td>
                                <td>'.$item['giam_gia'].' VNĐ</td>
                                <td>'.$item['ngay_nhap'].'</td>
                                <td>
                                    <a href="index.php?pg=products_updates&id_updates='.$item['id'].'" class="btn btn-warning"><i
                                            class="fa-solid fa-pen-to-square"></i> Sửa</a>
                                    <a href="index.php?pg=products&id_delete='.$item['id'].'" class="btn btn-danger"><i
                                            class="fa-solid fa-trash"></i> Xóa</a>
                                </td>
                            </tr>';
    }
    return $html_dssp_admin;
}

?>
