var CrudPageJs=new Class.create();CrudPageJs.prototype=Object.extend(new AdminPageJs(),{pagination:{pageNo:1,pageSize:30},resultDivId:null,showItems:function(c,b,e,a){var d={};d.me=this;d.me.pagination.pageNo=(c||d.me.pagination.pageNo);d.me.pagination.pageSize=(b||d.me.pagination.pageSize);d.itemId=(e||null);d.resetResult=(a===false?false:true);d.me.postAjax(d.me.getCallbackId("getItems"),{pagination:d.me.pagination,itemId:d.itemId},{onLoading:function(f,g){},onComplete:function(f,h){try{d.result=d.me.getResp(h,false,true);if(!d.result.items||d.result.items===undefined||d.result.items===null){throw"No item found/generated"}if(d.resetResult===true){$(d.me.resultDivId).update("");if($("total_no_of_items")){$("total_no_of_items").update(d.result.pagination.totalRows)}}d.index=(d.me.pagination.pageNo-1)*d.me.pagination.pageSize;$(d.me.resultDivId).insert({bottom:d.me._getResultDiv(d.result.items,d.resetResult,d.index)}).insert({bottom:d.me._getPaginBtns(d.result.pagination)})}catch(g){$(d.me.resultDivId).update(g)}}})},_getPaginBtns:function(a){if(a.pageNumber>=a.totalPages){return}var b={};b.me=this;b.paginDiv=new Element("div",{"class":"paginDiv"}).insert({bottom:new Element("span",{"class":"btn btn-success"}).update("Get more").observe("click",function(){$(this).up(".paginDiv").remove();b.me.showItems(b.me.pagination.pageNo+1,b.me.pagination.pageSize,null,false)})});return b.paginDiv},_getResultDiv:function(b,a,c){return null},_afterDelItems:function(a){var b={};b.me=this;a.each(function(c){b.row=$(b.me.resultDivId).down(".row[item_id="+c+"]");if(b.row){b.row.remove()}});return this},delItems:function(a){var b={};b.me=this;if(confirm("You are about to delete this item.\n Continue?")){b.me.postAjax(b.me.getCallbackId("deleteItems"),{itemIds:a},{onLoading:function(c,d){},onComplete:function(c,f){try{b.result=b.me.getResp(f,false,true);b.me._afterDelItems(a)}catch(d){alert(d)}}})}return this},showEditPanel:function(b,a){throw"function showEditPanel needs to be overrided!"},cancelEdit:function(a){throw"function cancelEdit needs to be overrided!"},_collectSavePanel:function(a){throw"function _collectSavePanel needs to be overrided!"},_afterSaveItems:function(b,a){throw"function _afterSaveItems needs to be overrided!"},saveEditedItem:function(b){var a={};a.me=this;a.data=a.me._collectSavePanel(b);if(a.data!==null){a.me.postAjax(a.me.getCallbackId("saveItems"),a.data,{onLoading:function(c,d){},onComplete:function(c,f){try{a.result=a.me.getResp(f,false,true);if(a.result.items===undefined||a.result.items===null||a.result.items.size()===0){throw"System Error: not items returned after saving!"}a.me._afterSaveItems(b,a.result)}catch(d){$(b).up(".savePanel").down(".msgRow").update(new Element("p",{"class":"alert alert-danger"}).update(d))}}})}return this},editItem:function(a){this._hideShowAllEditPens(a,false);this.showEditPanel(a);return this},createItem:function(a){this._hideShowAllEditPens(a,false);this.showEditPanel(a,true);return this},_hideShowAllEditPens:function(c,a){var b={};b.me=this;b.btnsDiv=$(c).up(".row").getElementsBySelector(".btns").first();if(a===true){b.btnsDiv.show()}else{b.btnsDiv.hide()}return this}});