<template>
    <section>
        <div class="loader-page">
            <div class="clock"></div>
        </div>

    </section>
</template>

<script>
    export default {}
</script>

<style lang="scss">

    .loader-page {
        position: fixed;
        width: 100%;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        background: #fff;
    }


    .clock{
        border-radius: 70px;
        border: 3px solid #959595;
        position: absolute;
        top: 50%;
        left: 50%;
        margin-left: -50px;
        margin-top: -50px;
        display: block;
        width: 120px;
        height: 120px;
    }

    .clock:after{
        content: "";
        position: absolute;
        background-color: #959595;
        top: 13px;
        left: 48%;
        height: 50px;
        width: 4px;
        border-radius: 5px;
        -webkit-transform-origin: 50% 97%;
        transform-origin: 50% 97%;
        -webkit-animation: grdAiguille 2s linear infinite;
        animation: grdAiguille 2s linear infinite;
    }

    @-webkit-keyframes grdAiguille{
        0%{-webkit-transform:rotate(0deg);}
        100%{-webkit-transform:rotate(360deg);}
    }

    @keyframes grdAiguille{
        0%{transform:rotate(0deg);}
        100%{transform:rotate(360deg);}
    }

    .clock:before{
        content: "";
        position: absolute;
        background-color: #959595;
        top: 24px;
        left: 48%;
        height: 40px;
        width: 4px;
        border-radius: 5px;
        -webkit-transform-origin: 50% 94%;
        transform-origin: 50% 94%;
        -webkit-animation: ptAiguille 12s linear infinite;
        animation: ptAiguille 12s linear infinite;
    }

    @-webkit-keyframes ptAiguille{
        0%{-webkit-transform:rotate(0deg);}
        100%{-webkit-transform:rotate(360deg);}
    }

    @keyframes ptAiguille{
        0%{transform:rotate(0deg);}
        100%{transform:rotate(360deg);}
    }



</style>