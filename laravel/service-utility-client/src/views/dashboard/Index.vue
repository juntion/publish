<template>
    <div>
        <div class="box">
            <div class="con">
                <img src="@/assets/images/empty.png">
                <p>Welcome</p>
            </div>
        </div>

    </div>
</template>

<script>
export default {
  name: 'Dashboard'
}
</script>

<style lang="less" scoped>
    .box {
        height: 600px;
        position: relative;
        .con {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            p {
                font-size: 16px;
                margin-top: 20px;
            }
        }
    }
</style>
