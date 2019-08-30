<?php  
$file_name = $_POST['filename'];    
$file_path = $_POST['filepath'];           
//检查文件是否存在    
if (! file_exists ( $file_path )) {    
    header('HTTP/1.1 404 NOT FOUND');  
} else {    
    //以只读和二进制模式打开文件   
    $file = fopen ( $file_path, "rb" ); 

    //告诉浏览器这是一个文件流格式的文件    
    Header ( "Content-type: application/octet-stream" ); 
    //请求范围的度量单位  
    Header ( "Accept-Ranges: bytes" );  
    //Content-Length是指定包含于请求或响应中数据的字节长度    
    Header ( "Accept-Length: " . filesize ( $file_path ) );  
    //用来告诉浏览器，文件是可以当做附件被下载，下载后的文件名称为$file_name该变量的值。
    Header ( "Content-Disposition: attachment; filename=" . $file_name );    

    //读取文件内容并直接输出到浏览器    
    echo fread ( $file, filesize ( $file_path ) );    
    fclose ( $file );    
    exit ();    
} 

?>