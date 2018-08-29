<?php
/**
 * @author ciabeta
 */

class Addanchor{
    /**
     * 加锚在抓取所有的分标题之后实现，传入的参数是
     * 0X0 目录
     * 一些列表目录
     * 
     * 之后的文本
     */
    private function only_add_anchor($single_text){
        /**
         * 先分割h2标题，随后再分割h3标题
         */
        $all_head2 = preg_split('<h2>', $single_text);
        $num = 0;
        foreach ($all_head2 as $each_one) {
            if(($num%2) == 0){
                /**
                 * 如果标题是偶数，说明是<h2>，有0，2，4，6
                 * 就加锚
                 */
                if($num == 0){
                    /**
                     * 第一个标题是0X0 目录，所以不分割，填充h2之后就过去了
                     */
                    $all_text .= $each_one."h2";
                }else if(($num+1) == sizeof($all_head2)){
                    /**
                     * 如果此时的号码加一是分割的所有字符，就执行直接合并。
                     * 假设算上目录有5个h2，就分割为10个，0~9，这时候是8
                     * 讲道理是最后一个h2，这里我也不懂了。
                     * 这特么的，看了好久，后面还有个文章导航的h2，没显示出来而已
                     */
                    // include('class.debug.php');
                    // $mydebug = new MyDebug;
                    // $mydebug->console_log($num);
                    // $mydebug->console_log(sizeof($all_head2));
                    $all_text .= $each_one;
                }else{
                    $all_text .= $each_one."h2 id=\"header2-".$num."\"";
                }
            }else{
                /**
                 * 奇数，直接补充h2，即可，表示</h2>
                 */
                $all_text .= $each_one."h2";
            }
            $num += 1;
        }

        /**
         * h2处理完了，开始处理h3
         */
        $all_head3 = preg_split('<h3>', $all_text);
        $num = 0;
        foreach ($all_head3 as $each_one) {
            if(sizeof($all_head3) == 1){
                /**
                 * 如果根本没h3，就不用切割了
                 */
                $all_texth3 = $all_text;
            }else if(($num%2) == 0){
                /**
                 * 是偶数就切割0，2，4，6
                 */
                if(($num+1) ==sizeof($all_head3)){
                    /**
                     * 这儿跟h2一样，有个发表评论和取消回复
                     */
                    $all_texth3 .= $each_one;
                }else{
                    $all_texth3 .= $each_one."h3 id=\"header3-".$num."\"";
                }
            }else{
                $all_texth3 .= $each_one."h3";
            }
            $num += 1;
        }
        return $all_texth3;
    }
    /**
     * 这个函数可以自动调用加锚函数，然后自己生成开头的0X0 目录
     * 然后后面的内容
     * 
     */
    public function add_index($content) {
        if(is_single()) {
            // [^>]表示不是“>”的字符，*表示重复零次或更多次，这个意思是非“>”的字符可以有一个或多个，也可以没有。
            // 点代表的是任意字符。
            // * 代表的是取 0 至 无限长度问号代表的是非贪婪模式。三个链接在一起是取尽量少的任意字符。
            $rex = "/(<(h2|h3|h4)>)(.*?)(<\/(h2|h3|h4)>)/";
            //通配所有h2h23h4
            preg_match_all($rex, $content, $matches,PREG_SET_ORDER);
            //生成顺序表
            $h3_num = 0;
            $num = 1;
            foreach ($matches as $val) {
                if($val[2] == "h2"){
                    //class="has-regular-font-size"
                    $label = '<p class="has-regular-font-size"><a href=#header2-'.($num*2).'>'.$val[3]."</a></p>";
                    $num += 1;
                }
                if($val[2] == "h3"){
                    //class="has-small-font-size"
                    $label = '<p class="has-small-font-size">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=#header3-'.($h3_num*2).'>'.$val[3]."</a></p>";
                    $h3_num += 1;
                }
                $headers .= $label;
            }
            $moreandh2 = preg_split('<h2>', $content, 2);
            if(sizeof($moreandh2) == 1){
                // 如果连个h2都没，就不用列什么目录了
                ;
            }else{
                /**
                 * 以下代码是补充目录和加锚了
                 * 从第一个h2开始分割，也就是以后的正文第一个就要是h2标签，以0X1开始
                 */
                $content = $moreandh2[0]."h2>0X0 目录</h2>".$headers."<h2".$moreandh2[1];
                $content = $this->only_add_anchor($content);
            }
          }
          return $content;
    }
    
    
}

?>