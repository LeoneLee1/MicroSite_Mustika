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

    .image-preview-container {
        width: 100px;
        background: #f8fafc;
        padding: 8px;
        border-radius: 10px;
        border: 1px dashed #e5e7eb;
    }

    .image-preview-wrapper {
        position: relative;
        display: inline-block;
        max-width: 150px;
        /* Reduced from 200px */
    }

    .image-preview-wrapper img {
        width: 80px;
        /* Fixed width */
        height: 80px;
        /* Fixed height */
        border-radius: 8px;
        object-fit: cover;
        /* This will maintain aspect ratio */
        border: 1px solid #e5e7eb;
    }

    .remove-image {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #ff4444;
        color: white;
        border: none;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        padding: 0;
        font-size: 10px;
    }

    .remove-image:hover {
        background: #cc0000;
        transform: scale(1.1);
    }
</style>
<link rel="stylesheet" href="css/slideshow.css">
