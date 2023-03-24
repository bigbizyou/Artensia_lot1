<template>


  <div class="box" style="margin-top:2rem;" >

    <div class="level-item">
      <div class="field has-addons">
        <p class="control">
          <input class="input" type="text" placeholder="Référence" v-model="ref" >
        </p>
        <p class="control">
          <b-button class="button is-primary" :loading="isRequest"  v-on:click=" generatePdf()" >
            Générer PDF
          </b-button>
        </p>
      </div>
    </div>


    <!-- print section -->

    <div id="printSection" class="page">

      page à imprimer

    </div>

    <!-- /print section -->
  </div>

</template>


<style>

  @page {
    size: A4;
    margin: 3cm;
  }
  .page-break {
    break-after: page;
  }
  #printSection {
    display: none;
  }
  @media print {
    @page {
      size: A4;
      margin: 3cm;
    }
    #printSection {
      display: block;
      height: 90000px
    }
    .page-break {
      break-after: page;
    }

  }


</style>

<script>
  export default {
    name: 'RequestPdf',
    data() {
      return {
        ref: '',
        inError: false,
        isRequest: false
      }
    },
    methods: {
      generatePdf: function() {
        this.isRequest = true;
        console.log( this.ref );
        this.$htmlToPaper("printSection");

      }
    }

  }
</script>
