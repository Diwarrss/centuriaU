<template>
  <div class="card">
    <div class="card-header">
      <i class="fas fa-users"></i> Información Persona
    </div>
    <div class="card-body">{{user}}</div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      user: []
    };
  },
  methods: {
    getUser() {
      let me = this;
      axios
        .get("http://apicenturia.test/api/getUsuarios", {
          params: {
            id: "1057516393"
          }
        })
        .then(function(response) {
          me.user = response.data;
          console.log(response.data);
        })
        .catch(function(error) {
          console.log(error);
        })
        .then(function() {
          // always executed
        });
    }
  },
  mounted() {
    this.getUser();
    console.log("Component mounted.");
  }
};
</script>
