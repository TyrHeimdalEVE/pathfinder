define(["jquery","module/base","app/map/util","app/util"],(e,t,a,s)=>{"use strict";let i=class TagsModule extends t{constructor(e={}){super(Object.assign({},new.target.defaultConfig,e))}render(e){this._bodyEl=Object.assign(document.createElement("div"),{className:this._config.bodyClassName}),this._mapId=e;let t=this.getTagList(e);return this.buildTagsTable(t),this.moduleElement.append(this._bodyEl),this.initTagModule(),this.moduleElement}initTagModule(){super.init()}getTagList(e){let a=[],i=["H","L","0.0","C1","C2","C3","C4","C5","C6"];if(t.Util.getMapModule().getActiveMap()){var l=s.getCurrentMapData(e);a=JSON.parse(l.config.nextBookmarks)}return a.forEach(function(e,t,a){a[t]=[i[t]],e.forEach(e=>{a[t].push(e)})}),a}buildTagsTable(e){let t=Object.assign(document.createElement("table"),{className:this._config.tagsTable,id:"table-id",style:"width: 90%; text-align: center; margin-left: auto; margin-right: auto;"});for(var i=0;i<e[0].length;i++){let l=t.insertRow();e.forEach(e=>{let t=Object.assign(l.insertCell(),{className:[this._config.systemSec,s.getSecurityClassForSystem(e[0])].join(" "),style:"width: 10%; padding: 5px;"}),r=document.createTextNode(0==i?a.getSystemSecurityForDisplay(e[i]).toLowerCase():e[i]);t.appendChild(r)})}this._bodyEl.append(t)}updateTagsTable(){let e=document.getElementById("table-id");e.parentElement.removeChild(e);let t=this.getTagList(this._mapId);return this.buildTagsTable(t),!0}update(e){return super.update(e).then(e=>new Promise(t=>{this.updateTagsTable(e),t({action:"update",data:{module:this}})}))}beforeHide(){super.beforeHide()}beforeDestroy(){super.beforeDestroy()}onSortableEvent(e,t){super.onSortableEvent(e,t)}};return i.isPlugin=!0,i.scope="system",i.sortArea="b",i.position=15,i.label="Bookmark Tags",i.defaultConfig={className:"pf-system-tag-module",innerClassName:"pf-system-tag-inner",sortTargetAreas:["a","b","c"],headline:"Bookmark Tags",systemSec:"pf-system-sec",tagsTable:"pf-tags-table"},i});
//# sourceMappingURL=tags.js.map
