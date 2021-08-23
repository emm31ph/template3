<template>
    <div>
        <router-view></router-view>
    </div>
</template>
<script>
export default {
    props: ["batch"],

    methods: {
        repType(data) {
            switch (data) {
                case "SH":
                    return "sh";
                    break;
                case "PL":
                    return "pl";
                    break;
                default:
                    this.$router.push({
                        name: "dashboard"
                    });
            }
        }
    },
    mounted() {
        if(this.batch==undefined){
        	this.$router.push({
        		name: "dashboard"
        	});
        }else{
            let trnmode = this.repType(this.batch.slice(0, this.batch.search("-")));
            this.$router.push({
                name: "log-report-"+trnmode.toLowerCase(),
                params: { id: this.batch }
            });
        }
    }
};
</script>

<style></style>
