//冒泡排序
function bubble(arr) {
	for (var i = 0; i < arr.length; i++) {
		for (var j = 0; j < arr.length - i - 1; j++) {
			if (arr[j] > arr[j + 1]) {
				var tmp = arr[j + 1];
				arr[j + 1] = arr[j];
				arr[j] = tmp;
			}
		}
	}
}

//选择排序
function choose(arr) {
	for (var i = 0; i < arr.length - 1; i++) {
		for (var j = i + 1; j < arr.length; j++) {
			if (arr[i] > arr[j]) {
				var tmp = arr[j];
				arr[j] = arr[i];
				arr[i] = tmp;
			}
		}
	}
}

//DOM封装函数
function $(vArg) {
	//1.对参数进行区分
	switch (vArg[0]) {
		case "#":
			return document.getElementById(vArg.substring(1));
			break;
		case ".":
			return elementByClassName(document, vArg.substring(1));
			break;
		default:
			//对参数前5个字符进行判断
			var str = vArg.substring(0, 5);
			if (str == "name=") {
				return document.getElementsByName(vArg.substring(5));
			} else {
				return document.getElementsByTagName(vArg);
			}
			break;
	}
}

//用class获取符合条件元素节点兼容函数
function elementByClassName(parent, classStr) {
	//1.找到parent下所有元素节点
	var nodes = parent.getElementsByTagName('*');
	var result = []; //用来记录符合条件的元素节点
	for (var i = 0; i < nodes.length; i++) {
		//2.如果符合条件添加到数组中
		if (nodes[i].className == classStr) {
			result.push(nodes[i]);
		}
	}
	return result;
}

//获取当前样式的兼容函数
function getStyle(elem, attr) {
	return elem.currentStyle ? elem.currentStyle[attr] : getComputedStyle(elem)[attr];
}

//从父元素删除空白节点
function removedSpaceNode2(parent) {
	var nodes = parent.childNodes;
	for (var i = 0; i < nodes.length; i++) {
		//判断是否是空白节点
		if (nodes[i].nodeType == 3 && /^\s+$/.test(nodes[i].nodeValue)) {
			parent.removeChild(nodes[i]);
		}
	}
}

//删除子节点空白节点
function removedSpaceNode(nodes) {
	var result = []; //用来存放不是空白节点的节点
	for (var i = 0; i < nodes.length; i++) {
		//判断是否是空白节点
		if (nodes[i].nodeType == 3 && /^\s+$/.test(nodes[i].nodeValue)) {
			continue;
		}
		result.push(nodes[i]);
	}
	return result;
}

//创建带文本元素节点
function creatElementWithTxt(tagName, txt) {
	var node = document.createElement(tagName);
	var oTxt = document.createTextNode(txt);
	node.appendChild(oTxt);
	return node;
}

//insertAfter()
function insertAfter(newNode, oldNode) {
	//判断oldNode是否是最后一个节点
	var parent = oldNode.parentNode;
	if (oldNode == parent.lastChild) {
		//最后一个节点直接插入到子节点末尾
		parent.appendChild(newNode);
	} else {
		//插入到oldNode的下一个节点之前
		parent.insertBefore(newNode, oldNode.nextSibling);
	}
}

//添加事件监视器兼容代码
function addEvent(obj, type, fun) {
	if (obj.addEventListener) {
		obj.addEventListener(type, fun, false);
	} else {
		obj.attachEvent("on" + type, fun);
	}
}

//移除事件监视器兼容代码
function removeEvent(obj, type, fun) {
	if (obj.removeEventListener) {
		obj.removeEventListener(type, fun, false);
	} else {
		obj.detachEvent("on" + type, fun);
	}
}

//cookie的封装
function setCookie(name, value, time) {
	var oDate = new Date();
	oDate.setDate(oDate.getDate() + time);
	document.cookie = name + "=" + value + ";expires=" + oDate;
}

function getCookie(name) {
	var str = document.cookie;
	var arr = str.split("; ");
	for (var i = 0; i < arr.length; i++) {
		var arr1 = arr[i].split("=");
		if (arr1[0] == name) {
			return arr[1];
		}
	}
}

function removeCookie(name) {
	setCookie(name, 1, -1);
}
