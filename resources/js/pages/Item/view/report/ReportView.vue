<template>
    <div>
        <router-view></router-view>
    </div>
</template>
<script>
export default {
   props: ["batch"] ,
   
    methods:{
        repType(data) {
            
            switch (data) { 
                case "RRM":   
                    return "RRM";
                    break;
                case "RR":  
                    return "RR";
                    break;
                case "WP":  
                    return "WP";
                    break;
                case "RJ":  
                    return "RJ";
                    break;
                case "ADJ":  
                    return "ADJ";
                    break;
                case "IMP": 
                    return "IMP";
                    break;
                case "DLVR": 
                    return "dlvry";
                    break;
                case "REV": 
                    return "rev";
                case "CAN": 
                    return "can";
                    break;
                default:
                this.$router.push({
                    name: "dashboard" 
                });
            }
        }
    },
    mounted(){  

        if(this.batch==undefined){
        	this.$router.push({
				name: "dashboard" 
			});
        }else{             
            let trnmode = this.repType(this.batch.slice(0, this.batch.search("-")));
           console.log(trnmode);
            this.$router.push({
                name: "report-"+trnmode.toLowerCase(),
                params: { id: this.batch }
            });
        }
    }
}
</script>

<style>

</style>