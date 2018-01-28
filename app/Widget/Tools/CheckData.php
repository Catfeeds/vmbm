<?php
/**
 * User: Mike
 * Email: m@9026.com
 * Date: 2016/6/28
 * Time: 16:49
 */


namespace App\Widget\Tools;

class CheckData {

    /**
     * 选择数据
     * @param $id 唯一编号
     * @param $dataUrl
     * @param $dataName 隐藏域
     * @param $field 数据
     * @param $data 默认数据
     * @param int $num 限制数量
     */
    public function run($id,$dataUrl,$dataName='data',$field=['id'=>'编号','name'=>'商品名称'],$data=[],$dataKey='id',$num=9999) {
        $callBack = "checkDataCallBack" . $id;
        $getData = "getData" . $id;
        $dataUrl = U($dataUrl,['callBack'=>$callBack,'getData'=>$getData]);
        $html ="<a id='{$id}_button' class='btn btn-success'>选择数据</a>";
        $th = "";
        $td = "";
        $dataTd = "";
        foreach($field as $key=>$val) {
            $th .="<th data-field='$key'>$val</th>";
            $td .= "<td><input type='hidden' name='$dataName\[$key\][]' value='\" + data.$key + \"'/> \"+data.$key+\"</td>";
        }

        foreach($data as $val) {
            $dataTd .= "<tr data-key=\"{$val[$dataKey]}\" align='center'>";

            foreach($field as $k=>$v) {
                $dataTd .= "<td><input type='hidden' name='{$dataName}[$k][]' value='{$val[$k]}'/>{$val[$k]}</td>";
            }
            $dataTd .= "<td><a href='#' onclick='$(this).parent().parent().remove();'>删除</a></td></tr>";
        }

        $html .= <<<EOF
            <div class='ng-scope img-input-block list'>
             <table id="checkDataTable$id" class='table table-striped table-bordered table-hover dataTables-example dataTable'>
                <thead>
                    <tr>
                        $th
                        <th data-field='action' data-formatter='actionFormatter' data-events='actionEvents'>操作</th>
                    </tr>
                </thead>
                <tbody>
                    $dataTd
                </tbody>
                </table>
               </div>
               <script type='text/javascript'>
                    $(function() {
                       $("#{$id}_button").click(function() {
                            layer.open({
                                type: 2,
                                title: '选择数据',
                                shadeClose: true,
                                shade: 0.8,
                                area: ['80%', '80%'],
                                maxmin: true,
                                content: '$dataUrl',
                                btn: ['完成选择'],
                                yes:function(index, layero){
                                    layer.close(index);
                                },
                                end:function(index,msg){ }
                            });
                        });
                    });
                    function $callBack(index,data,checked) {

                        dataTr = $('#checkDataTable$id tbody').find('tr[data-key="'+index+'"]');
                        if(checked) {
                            html = "<tr data-key="+index+" align='center'>";
                            html +="$td";
                            html +="<td><a href='#' onclick='$(this).parent().parent().remove();'>删除</a></td></tr>";

                            //如果一条数据，那么处理逻辑就是替换
                            if($num ==1) {
                                $('#checkDataTable$id tbody').html(html);
                                return 1;
                            }
                            if(dataTr.length>0) {
                                return true;
                            }
                            if($('#checkDataTable$id tbody tr').length>$num-1) {
                                layer.msg("最多选择{$num}条数据");
                                return false;
                            }

                            $('#checkDataTable$id tbody').append(html);
                      }else{
                        if(dataTr.length>0) {
                           dataTr.remove();
                        }
                      }
                      return true;
                    }
                    function $getData() {
                        var keys = [];
                        dataTr = $('#checkDataTable$id tbody tr').each(function() {
                            keys.push($(this).data('key').toString());
                        });
                        console.log(keys);
                        return keys;
                    }
                    var arr = [ "xml", "html", "css", "js" ];


               </script>
EOF;
        return $html;
    }


}