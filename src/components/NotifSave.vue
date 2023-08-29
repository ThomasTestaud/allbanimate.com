<template>
    <div class="notif">
        <div class="loader"></div>
        <p>We are saving you project...</p>
    </div>
</template>

<script>
    export default {
        name: 'NotifSave',
    }
</script>

<style scoped>

    .notif {
        position: fixed;
        bottom: 50px;
        left: 20px;
        border: 2px solid var(--border-color);
        background-color: var(--element-background-color);
        border-radius: 10px;
        padding: 10px;
        display: flex;
        align-items: center;
        animation: appear 1s;
    }
    .loader {
        height: 30px;
        width: 30px;
        border-radius: 50%;
        border: 5px solid rgba(255, 255, 255, 0);
        border-top: 5px solid rgba(255, 255, 255, 0.663);
        border-bottom: 5px solid rgba(255, 255, 255, 0.663);
        animation: turn 1s linear infinite;
        margin-right: 15px;
    }

    @keyframes turn {
        from {
            transform: rotate(0turn);
        }
        to {
            transform: rotate(1turn);
        }
    }

    @keyframes appear {
	from {
		opacity: 0;
		transform: translate(0px, 100px);
	}

	to {
		opacity: 1;
		transform: translate(0px, 0px);
	}
}

</style>