laravel-admin extension 商品SKU
======

![预览](https://github.com/jade-kun/sku/blob/master/1.png?raw=true)

## 安装
```bash
composer require hanson/laravel-admin-sku

php artisan vendor:publish --tag=sku
```

## 配置

### 配置sku上传地址

文件路径 `public/vendor/hanson/sku/sku.js`

```javascript
const UploadHost = '/admin/upload_file';
```

php进行存储

```php
// key为file
if($request->hasFile('file')) {
    $file = $request->file('file');
    $path = $file->store('images');

    // 返回格式
    return ['url'=> Storage::url($path)];
}
```

## 使用

```php
$form->sku('sku','商品SKU')->default($json);

// 处理数据
$form->saving(function($form) {
    dd($form->sku);
});
```

本扩展只会将SKU数据写指定的字段中，如需个性化处理数据，请在【表单回调】中处理

原始数据
```json
{
	"type": "many", // many多规格；single单规格
	"attrs": {"尺寸": ["XL", "XXL", "XXXL"], "颜色": ["黑", "灰色"]},
    "sku": [{"pic": "", "price": "89", "stock": "100", "尺寸": "XL", "颜色": "黑"}, {
        "pic": "",
        "price": "89",
        "stock": "100",
        "尺寸": "XL",
        "颜色": "灰色"
    }, {"pic": "", "price": "89", "stock": "100", "尺寸": "XXL", "颜色": "黑"}, {
        "pic": "",
        "price": "89",
        "stock": "100",
        "尺寸": "XXL",
        "颜色": "灰色"
    }, {"pic": "", "price": "89", "stock": "100", "尺寸": "XXXL", "颜色": "黑"}, {
        "pic": "",
        "price": "89",
        "stock": "100",
        "尺寸": "XXXL",
        "颜色": "灰色"
    }]
}
```

## 自定义 sku 数据

以下操作均为修改 `public/vendor/hanson/sku/sku.js`

### 例子

* 增加一列 SKU 编号

`第231行`

```html
tbody_html += '<td data-field="pic"><input value="" type="hidden" class="form-control"><span class="Js_sku_upload">+</span><span class="Js_sku_del_pic">清空</span></td>';
tbody_html += '<td data-field="id" style="display: none;"><input value="" type="hidden"></td>';
tbody_html += '<td data-field="price"><input value="' + _this.commonPrice + '" type="text" class="form-control"></td>';
tbody_html += '<td data-field="stock"><input value="' + _this.commonStock + '" type="text" class="form-control"></td>';
<!-- 增加一行，json中带有 sku_no 便可自动带入 -->
tbody_html += '<td data-field="sku_no"><input value="" type="text" class="form-control"></td>';
tbody_html += '</tr>'
```

* 给上面的 sku 编号增加全局输入

`第9行`

```javascript
this.commonStock = 0; // 统一库存
this.commonPrice = 0; // 统一价格
this.commonSku = ''; // 统一sku
this.init();
```

`第96行`

```javascript
// 统一sku
_this.warp.find('.sku_edit_warp thead').on('keyup', 'input.Js_sku', function () {
    _this.commonStock = $(this).val();
    _this.warp.find('.sku_edit_warp tbody td[data-field="sku_no"] input').val(_this.commonStock);
    _this.processSku()
});
```

`第203行`
```html
thead_html += '<th style="width: 100px">图片</th>';
thead_html += '<th style="width: 100px">价格 <input value="' + _this.commonPrice + '" type="text" style="width: 50px" class="Js_price"></th>';
thead_html += '<th style="width: 100px">库存 <input value="' + _this.commonStock + '" type="text" style="width: 50px" class="Js_stock"></th>';
thead_html += '<th style="width: 100px">sku <input value="' + _this.commonSku + '" type="text" style="width: 50px" class="Js_sku"></th>';
thead_html += '</tr>';
```

`第231行`

```html
tbody_html += '<td data-field="pic"><input value="" type="hidden" class="form-control"><span class="Js_sku_upload">+</span><span class="Js_sku_del_pic">清空</span></td>';
tbody_html += '<td data-field="id" style="display: none;"><input value="" type="hidden"></td>';
tbody_html += '<td data-field="price"><input value="' + _this.commonPrice + '" type="text" class="form-control"></td>';
tbody_html += '<td data-field="stock"><input value="' + _this.commonStock + '" type="text" class="form-control"></td>';
<!-- 增加一行，json中带有 sku_no 便可自动带入 -->
tbody_html += '<td data-field="sku_no"><input value="' + _this.commonSku + '" type="text" class="form-control"></td>';
tbody_html += '</tr>'
```

* 去掉 sku 图片

`231行处` 把 pic 的一行删掉

```html
tbody_html += '<td data-field="id" style="display: none;"><input value="" type="hidden"></td>';
tbody_html += '<td data-field="price"><input value="' + _this.commonPrice + '" type="text" class="form-control"></td>';
tbody_html += '<td data-field="sku_no"><input value="" type="text" class="form-control"></td>';
tbody_html += '</tr>'
```

## 感谢

感谢 jade-kun 的 [sku](https://github.com/jade-kun/sku) 项目，此项目在原项目中修改并加以完善
