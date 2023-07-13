<base href="${baseUri}/view/admin/">
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="${baseUri}/view/admin/assets/plugins/fontawesome-free/css/all.min.css">
<!-- IonIcons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="${baseUri}/view/admin/assets/dist/css/adminlte.min.css">
<link rel="stylesheet" href="${baseUri}/view/admin/assets/plugins/dropify/dist/css/dropify.min.css">
<link rel="stylesheet" href="${baseUri}/view/admin/assets/plugins/dropzone-master/dist/dropzone.css">
<link rel="stylesheet" href="${baseUri}/view/admin/assets/plugins/toast-master/css/jquery.toast.css">
<link rel="stylesheet" href="${baseUri}/view/admin/assets/plugins/bootstrap-select/bootstrap-select.min.css" />
<link rel="stylesheet" href="${baseUri}/view/admin/assets/plugins/datatables/rowReorder.dataTables.min.css">
<link rel="stylesheet" href="${baseUri}/view/admin/assets/plugins/summernote/summernote-lite.css">
<link rel="stylesheet" href="${baseUri}/view/admin/assets/plugins/select2/css/select2.css">
<link rel="stylesheet" href="${baseUri}/view/admin/assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" />
<!-- DataTables -->
<link rel="stylesheet" href="${baseUri}/view/admin/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="${baseUri}/view/admin/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="${baseUri}/view/admin/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="${baseUri}/view/admin/assets/plugins/lightbox/css/lightbox.css">

<style>
    .pointer {
        cursor: pointer !important;
    }

    .not-allowed {
        cursor: not-allowed !important;
    }

    .select2-selection__rendered {
        line-height: 2.20rem !important;
    }

    .select2-container .select2-selection--single {
        height: 2.20rem !important;
    }

    .select2-selection__arrow {
        height: 2.20rem !important;
    }

    .page-wrapper {
        height: 100vh !important;
        overflow-y: auto;
    }

    @keyframes spinner-border {
        to {
            transform: rotate(360deg);
        }
    }

    .spinner-border {
        display: inline-block;
        width: 2rem;
        height: 2rem;
        vertical-align: text-bottom;
        border: 0.25em solid currentColor;
        border-right-color: transparent;
        border-radius: 50%;
        animation: spinner-border .75s linear infinite;
    }

    .spinner-border-sm {
        width: 1rem;
        height: 1rem;
        border-width: 0.2em;
    }

    .el-element-overlay .el-card-item {
        position: relative;
        padding-bottom: 15px;
    }

    .el-element-overlay .el-card-item .el-card-avatar {
        margin-bottom: 15px;
    }

    .el-element-overlay .el-card-item .el-card-content {
        text-align: center;
    }

    .el-element-overlay .el-card-item .el-card-content h3 {
        margin: 0px;
    }

    .el-element-overlay .el-card-item .el-card-content a {
        color: #67757c;
    }

    .el-element-overlay .el-card-item .el-card-content a:hover {
        color: #009efb;
    }

    .el-element-overlay .el-card-item .el-overlay-1 {
        width: 100%;
        overflow: hidden;
        position: relative;
        text-align: center;
        cursor: default;
    }

    .el-element-overlay .el-card-item .el-overlay-1 img {
        display: block;
        position: relative;
        -webkit-transition: all .4s linear;
        transition: all .4s linear;
        width: 100%;
        height: auto;
    }

    .el-element-overlay .el-card-item .el-overlay-1:hover img {
        -ms-transform: scale(1.2) translateZ(0);
        -webkit-transform: scale(1.2) translateZ(0);
        /* transform: scale(1.2) translateZ(0); */
    }

    .el-element-overlay .el-card-item .el-overlay-1 .el-info {
        text-decoration: none;
        display: inline-block;
        text-transform: uppercase;
        color: #fff;
        background-color: transparent;
        filter: alpha(opacity=0);
        -webkit-transition: all .2s ease-in-out;
        transition: all .2s ease-in-out;
        padding: 0;
        margin: auto;
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        transform: translateY(-50%) translateZ(0);
        -webkit-transform: translateY(-50%) translateZ(0);
        -ms-transform: translateY(-50%) translateZ(0);
    }

    .el-element-overlay .el-card-item .el-overlay-1 .el-info>li {
        list-style: none;
        display: inline-block;
        margin: 0 3px;
    }

    .el-element-overlay .el-card-item .el-overlay-1 .el-info>li a {
        border-color: #fff;
        color: #fff;
        padding: 12px 15px 10px;
    }

    .el-element-overlay .el-card-item .el-overlay-1 .el-info>li a:hover {
        background: #009efb;
        border-color: #009efb;
    }

    .el-element-overlay .el-card-item .el-overlay {
        width: 100%;
        height: 100%;
        position: absolute;
        overflow: hidden;
        top: 0;
        left: 0;
        opacity: 0;
        background-color: rgba(0, 0, 0, 0.7);
        -webkit-transition: all .4s ease-in-out;
        transition: all .4s ease-in-out;
    }

    .el-element-overlay .el-card-item .el-overlay-1:hover .el-overlay {
        opacity: 1;
        filter: alpha(opacity=100);
        -webkit-transform: translateZ(0);
        -ms-transform: translateZ(0);
        transform: translateZ(0);
    }

    .el-element-overlay .el-card-item .el-overlay-1 .scrl-dwn {
        top: -100%;
    }

    .el-element-overlay .el-card-item .el-overlay-1 .scrl-up {
        top: 100%;
        height: 0px;
    }

    .el-element-overlay .el-card-item .el-overlay-1:hover .scrl-dwn {
        top: 0px;
    }

    .el-element-overlay .el-card-item .el-overlay-1:hover .scrl-up {
        top: 0px;
        height: 100%;
    }

    .border-default {
        border: 3px solid transparent;
    }

    .border3px {
        border: 3px solid red;
    }

    .user-panel img {
        min-width: 40px;
        min-height: 40px;
        object-fit: cover;
    }

    .show-mobile {
        display: none;
    }

    @media screen and (max-width: 1100px) {
        .show-mobile {
            display: block;
        }
    }

    .nav-link {
        font-size: 14px;
    }

    .btn-custom-checkbox {
        width: 25px;
        height: 25px;
        text-align: center;
        vertical-align: center;
        border: 1px solid #007bff;
        color: white;
        background: white;
        font-size: 12px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin-bottom: 5px;
    }

    .btn-custom-checkbox.custom-checkbox-active {
        color: #007bff;
    }
</style>