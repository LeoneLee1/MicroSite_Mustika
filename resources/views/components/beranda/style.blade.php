<style>
    input[type="radio"]:disabled {
        opacity: 1 !important;
        cursor: not-allowed;
    }

    input[type="radio"]:disabled+label {
        color: #000000;
    }

    .refresh-button {
        position: fixed;
        bottom: 80px;
        right: 20px;
        z-index: 9999;
        width: 40px;
        height: 40px;
        background-color: #6777ef;
        color: #fff;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 15px;
    }

    #ask_ai {
        outline: none;
        border: none;
        background: transparent;
    }

    #icon-input {
        outline: none;
        border: none;
        background: transparent;
    }

    .fa-heart.liked {
        color: red;
    }
</style>
<link rel="stylesheet" href="css/slideshow.css">
