<template>
  <li class="parent" v-if="item.access" ><router-link :to="{ name: item.link }">{{ item.title}} <span class="expand" v-if="item.childs">»</span></router-link>
  <template v-if="item.childs">
    <ul class="child">
      <menu-item v-for="(r, i) in item.childs" :key="i" :item="r"> </menu-item> 
    </ul>
  </template> 
  </li>    
</template>

<script>
export default {
 name: "menu-item",
  props: {
   
    item: {
      type: Object,
    },
  },
}
</script>

<style>
.parent {display: block;position: relative;float: left;line-height: 30px;background-color: #4FA0D8;border-right:#CCC 1px solid;}
.parent a{margin: 10px;color: #FFFFFF;text-decoration: none;}
.parent:hover > ul {display:block;position:absolute;}

.parent ul{list-style: none;margin: 0;padding: 0px; min-width:10em; z-index: 1000;}
.parent ul ul ul{left: 100%;top: 0;margin-left:1px;}
.parent li:hover {background-color: #95B4CA;}
.parent li:hover {background-color: #F0F0F0;}
.child {display: none;}
.child li {background-color: #E4EFF7;line-height: 30px;border-bottom:#CCC 1px solid;border-right:#CCC 1px solid; width:100%;}
.child li a{color: #000000;}
.expand{font-size:12px;float:right;margin-right:5px;}
</style>