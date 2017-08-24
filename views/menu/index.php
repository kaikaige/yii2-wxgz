<?php
/**
 * @var $this yii\web\View
 */
use kaikaige\vue\VueResourceAsset;
use yii\bootstrap\BootstrapAsset;
use yii\web\View;
BootstrapAsset::register($this);
VueResourceAsset::register($this);
?>

<div id="app" class="container">
	<table class="table table-hover table-bordered" v-for="(menu, key) in menus">
		<tr>
			<td colspan="1">{{menu.name}}</td>
			<td>{{menu.type ? menu.type : "菜单列表"}}</td>
			<td>
				<button class="btn btn-info" @click="update(menu)"><i class="glyphicon glyphicon-edit">修改</i></button>
				<button class="btn btn-primary" @click="add_btn(menu)" v-if="!menu.type && (!menu.sub_button || menu.sub_button.length<5)"><i class="glyphicon glyphicon-plus">添加</i></button>
				<button class="btn btn-danger" @click="del_menu(key)"><i class="glyphicon glyphicon-minus">删除</i></button>
			</td>
		</tr>
		<tr v-show="menu.sub_button && menu.sub_button.length>0" v-for="button,index in menu.sub_button">
			<td></td>
			<td>---{{button.name}}</td>
			<td>{{button.type}}<td>
			<td>
				<button class="btn btn-info" @click="update(button)"><i class="glyphicon glyphicon-edit">修改</i></button>
				<button class="btn btn-danger" @click="del_btn(menu.sub_button, index)"><i class="glyphicon glyphicon-minus">删除</i></button>
			</td>
		</tr>
	</table>
	  <div id="myModal" v-if="showForm">  
			<form class="form-horizontal">
				  <div class="form-group" style="margin-top:20px;">
				  	<div class="col-sm-1"></div>
				    <div class="col-sm-2">菜单名</div>
				    <div class="col-sm-8"><input type="text" v-model="btn.name" class="form-control" placeholder="菜单名"></div>
				  </div>
				  <div class="form-group">
				  	<div class="col-sm-1"></div>
				    <div class="col-sm-2">类型</div>
				    <div class="col-sm-8">
				    		<select v-model="btn.type" class="form-control">
				    			<option v-for="(item, key) in menuTypes" :value="key">{{item.name}}</option>
				    		</select>
				    		<div class="alert alert-success" role="alert" v-if="btn.type">{{menuTypes[btn.type].alert}}</div>
				    </div>
				  </div>
				  <div class="form-group" style="margin-top:20px;" v-if="btn.type && btn.type == 'view'">
				  	<div class="col-sm-1"></div>
				    <div class="col-sm-2">URL</div>
				    <div class="col-sm-8"><input type="text" v-model="btn.url" class="form-control" placeholder="Url"></div>
				  </div>
				  <div class="form-group" style="margin-top:20px;" v-if="btn.type && btn.type == 'click'">
				  	<div class="col-sm-1"></div>
				    <div class="col-sm-2">Key</div>
				    <div class="col-sm-8"><input type="text" v-model="btn.key" class="form-control" placeholder="关键字"></div>
				  </div>
				  <div style="text-align: center; display:block;margin-top:10px; margin-bottom:20px;">
				  	<span class="btn btn-primary" @click="sub">确认</span>
				  	<button class="btn btn-danger" @click="close">Close</button>
				  </div>
			</form>
	  </div>  
	  <div id="over" v-if="showForm"></div>  
	  <button class="btn btn-success" v-show="menus.length < 3" @click="add_menu">添加一级菜单</button>
	  <button class="btn btn-success" @click="push_wx">推送微信</button>
	  <button class="btn btn-danger" @click="clear">清空菜单</button>
</div>
<?php
$js = <<<JS
var app = new Vue({
	el:"#app",
 	data:{
		menus:{$menus},
		menuTypes:{$menuTypes},
		btn:{type:"", name:""},
		showForm:false,
		add_type:"",
	},
	methods:{
		update(obj) {
			this.btn = obj
			this.showForm = true
		},
		add_btn(menu) {
			this.add_type = "add_btn"
			this.showForm = true
			this.btn.menu = menu
		},
		add_menu() {
			this.add_type = "add_menu"
			this.showForm = true
		},
		del_btn(menu, index) {
			menu.splice(index, 1)
		},
		del_menu(key) {
			this.menus.splice(key, 1)
		},
		close() {
			this.add_type = ""
			this.btn = {
				name:"",
				type:""
			}
			this.showForm = false
		},
		sub() {
			if (this.menuTypes[this.btn.type] && this.menuTypes[this.btn.type].value) {
				this.btn.key = this.menuTypes[this.btn.type].value
			} else {
				Vue.delete(this.btn, "key") 
			}
			if (this.menuTypes[this.btn.type] == "view") {
				Vue.delete(this.btn, "key")
			}
			if (this.add_type == "add_menu") {
				this.menus.push(this.btn)
			} else if (this.add_type == "add_btn") {
				let menu = this.btn.menu
				Vue.delete(this.btn, "menu")
				if (!menu.sub_button) {
					menu.sub_button = []
				}
				menu.sub_button.push(this.btn)
			}
			this.close()
		},
		push_wx() {
			Vue.http.post("", {menus:this.menus, action:"update"}, {emulateJSON:true}).then(res=>{
				let data = res.data
				if(data.errcode == 0) alert("修改成功");
				else alert("修改失败")
			})
		},
		clear() {
			Vue.http.post("", {action:"clear"}, {emulateJSON:true}).then(res=>{
				let data = res.data
				if(data.errcode == 0) {
					alert("清除成功")
					window.location.reload()
				} else {
					alert("清除失败")
				}
			})
		}
	}
}) 
JS;
$this->registerJs($js, View::POS_END);
?>
 <style type="text/css">  
    #myModal 
    {  
        width:50%;  
        position:absolute;/*让节点脱离文档流,我的理解就是,从页面上浮出来,不再按照文档其它内容布局*/  
        top:24%;/*节点脱离了文档流,如果设置位置需要用top和left,right,bottom定位*/  
        left:24%;  
        z-index:2;/*个人理解为层级关系,由于这个节点要在顶部显示,所以这个值比其余节点的都大*/  
        background: white;  
    }  
    #over  
    {  
        width: 100%;  
        height: 100%;  
        opacity:0.8;/*设置背景色透明度,1为完全不透明,IE需要使用filter:alpha(opacity=80);*/  
        filter:alpha(opacity=80);  
        position:absolute;  
        top:0;  
        left:0;  
        z-index:1;  
        background: silver;  
    }  
    </style>  