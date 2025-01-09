<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title> Admin</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
</head>
<body>
<div class="container-fluid page-body-wrapper">
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="admin.php">
              <i class="mdi mdi-home menu-icon"></i>
              <span class="menu-title">Dashboard</span>
              
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="manageusers.php">
            <i class="mdi mdi-circle-outline menu-icon"></i>
              <span class="menu-title">Manage Users</span>
            </a>
          </li>
          

          <li class="nav-item">
  <a class="nav-link" data-toggle="collapse" href="#ui-product" aria-expanded="false" aria-controls="ui-product">
    <i class="mdi mdi-circle-outline menu-icon"></i>
    <span class="menu-title">Product</span>
    <i class="menu-arrow"></i>
  </a>
  <div class="collapse" id="ui-product">
    <ul class="nav flex-column sub-menu">
      <li class="nav-item"> <a class="nav-link" href="add_product.php">Add product</a></li>
      <li class="nav-item"> <a class="nav-link" href="manageproduct.php">Manage product</a></li>
    </ul>
  </div>
</li>
          <li class="nav-item">
  <a class="nav-link" data-toggle="collapse" href="#ui-category" aria-expanded="false" aria-controls="ui-category">
    <i class="mdi mdi-circle-outline menu-icon"></i>
    <span class="menu-title">Category</span>
    <i class="menu-arrow"></i>
  </a>
  <div class="collapse" id="ui-category">
    <ul class="nav flex-column sub-menu">
      <li class="nav-item"> <a class="nav-link" href="addcategory.php">Add Category</a></li>
      <li class="nav-item"> <a class="nav-link" href="managecategory.php">Manage category</a></li>
    </ul>
  </div>
</li>
<li class="nav-item">
  <a class="nav-link" data-toggle="collapse" href="#ui-stock" aria-expanded="false" aria-controls="ui-stock">
    <i class="mdi mdi-circle-outline menu-icon"></i>
    <span class="menu-title">Stock Summary</span>
    <i class="menu-arrow"></i>
  </a>
  <div class="collapse" id="ui-stock">
    <ul class="nav flex-column sub-menu">
      <li class="nav-item"> <a class="nav-link" href="stockdet.php">View Stock Details</a></li>
      <li class="nav-item"> <a class="nav-link" href="managestock.php">Add new Stock</a></li>
    </ul>
  </div>
</li>
<li class="nav-item">
  <a class="nav-link" data-toggle="collapse" href="#ui-size" aria-expanded="false" aria-controls="ui-size">
    <i class="mdi mdi-circle-outline menu-icon"></i>
    <span class="menu-title">Manage Sizes </span>
    <i class="menu-arrow"></i>
  </a>
  <div class="collapse" id="ui-size">
    <ul class="nav flex-column sub-menu">
      <li class="nav-item"> <a class="nav-link" href="add_sizes.php">Add Sizes</a></li>
      <li class="nav-item"> <a class="nav-link" href="managesizes.php">Manage Sizes</a></li>
    </ul>
  </div>
</li>
        </ul>
      </nav>
       <!-- plugins:js -->
  <style>
    .sidebar .nav:not(.sub-menu) > .nav-item > .nav-link {
    margin: 0;
}
.sidebar .nav .nav-item.active > .nav-link {
    background: initial;
    position: relative;
}
.sidebar .nav .nav-item .nav-link {
    display: -webkit-flex;
    display: flex;
    -webkit-align-items: center;
    align-items: center;
    white-space: nowrap;
    padding: 0.75rem 2.5rem 0.75rem 1.25rem;
    color: #000;
    -webkit-transition-duration: 0.45s;
    -moz-transition-duration: 0.45s;
    -o-transition-duration: 0.45s;
    transition-duration: 0.45s;
    transition-property: color;
    -webkit-transition-property: color;
}
.nav-link {
    display: block;
    padding: 0.5rem 1rem;
}
.btn, .btn-group.open .dropdown-toggle, .btn:active, .btn:focus, .btn:hover, .btn:visited, a, a:active, a:checked, a:focus, a:hover, a:visited, body, button, button:active, button:hover, button:visited, div, input, input:active, input:focus, input:hover, input:visited, select, select:active, select:focus, select:visited, textarea, textarea:active, textarea:focus, textarea:hover, textarea:visited {
    -webkit-box-shadow: none;
    -moz-box-shadow: none;
    box-shadow: none;
}
a, div, h1, h2, h3, h4, h5, p, span {
    text-shadow: none;
}
a {
    color: #007bff;
    text-decoration: none;
    background-color: transparent;
}
*, *::before, *::after {
    box-sizing: border-box;
}
user agent stylesheet
a:-webkit-any-link {
    color: -webkit-link;
    cursor: pointer;
    text-decoration: underline;
}
ul li, ol li, dl li {
    line-height: 1.8;
}
user agent stylesheet
li {
    text-align: -webkit-match-parent;
}
.nav {
    display: flex;
    flex-wrap: wrap;
    padding-left: 0;
    margin-bottom: 0;
    list-style: none;
}
ul, ol, dl {
    padding-left: 1rem;
    font-size: 0.875rem;
}
user agent stylesheet
ul {
    list-style-type: disc;
}
.sidebar {
    min-height: calc(100vh - 60px);
    background: #ffffff;
    font-family: "Roboto", sans-serif;
    font-weight: 400;
    padding: 0;
    width: 257px;
    z-index: 11;
    transition: width 0.25s ease, background 0.25s ease;
    -webkit-transition: width 0.25s ease, background 0.25s ease;
    -moz-transition: width 0.25s ease, background 0.25s ease;
    -ms-transition: width 0.25s ease, background 0.25s ease;
    box-shadow: none;
    -webkit-box-shadow: none;
    -moz-box-shadow: none;
    -ms-box-shadow: none;
    border-right: 1px solid #e3e3e3;
}
body {
    font-size: 1rem;
    font-family: "Roboto", sans-serif;
    font-weight: initial;
    line-height: normal;
    -webkit-font-smoothing: antialiased;
}
body {
    margin: 0;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #000;
    text-align: left;
    background-color: #fff;
}
html {
    font-family: sans-serif;
    line-height: 1.15;
    -webkit-text-size-adjust: 100%;
    -webkit-tap-highlight-color: transparent;
}
*, *::before, *::after {
    box-sizing: border-box;
}
*, *::before, *::after {
    box-sizing: border-box;
}
    </style>
<style>
    .mdi-sort-variant:before {
    content: "\F4BF";
}
.mdi:before, .mdi-set {
    display: inline-block;
    font: normal normal normal 24px/1 "Material Design Icons";
    font-size: inherit;
    text-rendering: auto;
    line-height: inherit;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}
*, *::before, *::after {
    box-sizing: border-box;
}
a, div, h1, h2, h3, h4, h5, p, span {
    text-shadow: none;
}
.navbar .navbar-brand-wrapper .navbar-brand-inner-wrapper .navbar-toggler {
    border: 0;
    color: #4a4a4a;
    font-size: 1.5rem;
    padding: 0;
}
button:not(:disabled), [type="button"]:not(:disabled), [type="reset"]:not(:disabled), [type="submit"]:not(:disabled) {
    cursor: pointer;
}
.navbar-toggler {
    padding: 0.25rem 0.75rem;
    font-size: 1.25rem;
    line-height: 1;
    background-color: transparent;
    border: 1px solid transparent;
    border-radius: 0.25rem;
}
    </style>
  <!-- End custom js for this page-->
</body>
</html>
