<!DOCTYPE html>
<html lang="en">
<head>
    <title>GastroHub System Portal</title>
    <?php include("../templates/head_links.php"); ?>
</head>
<body>
    <div class="container" style="height:100vh;">
        <div class="row" style="display:flex; justify-content:center; align-items:center; margin-top:5%;">
            <div class="col-md-offset-1 col-md-6">
                <h1>GastroHub System Admin Portal</h1>
                <h3>Add a new item to the inventory</h3><br/>
                <form action="process_add_library_item.php" name="verify-form" method="post" autocomplete="off">
                    <div class="row form-group my-3">
                        <div class="col-md-3">    
                            <h4>Item type:</h4>
                        </div>
                        <div class="col-md-3">
                            <select name="item_type" class="form-control" required>
                                <option value="book">book</option>
                                <option value="article">article</option>
                                <option value="journal">journal</option>
                                <option value="magazine">magazine</option>
                                <option value="newspaper">newspaper</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group my-3">
                        <div class="col-md-3">    
                            <h4>Title:</h4>
                        </div>
                        <div class="col-md-9">
                            <input type="text" maxlength="100" name="title" class="form-control" required/>
                        </div>
                    </div>
                    <div class="row form-group my-3">
                        <div class="col-md-3">    
                            <h4>Author:</h4>
                        </div>
                        <div class="col-md-9">
                            <input type="text" maxlength="100" name="author" class="form-control"/>
                        </div>
                    </div>
                    <div class="row form-group my-3">
                        <div class="col-md-3">    
                            <h4>Publisher:</h4>
                        </div>
                        <div class="col-md-9">
                            <input type="text" maxlength="100" name="publisher" class="form-control"/>
                        </div>
                    </div>     
                    <div class="row form-group my-3">
                        <div class="col-md-3">    
                            <h4>Image:</h4>
                        </div>
                        <div class="col-md-9">
                            <input type="file" accept=".png" name="image" class="form-control"/>
                        </div>
                    </div>
                    <div class="row form-group my-3">
                        <div class="col-md-3">    
                            <h4>ISBN:</h4>
                        </div>
                        <div class="col-md-9">
                            <input type="text" maxlength="100" name="ISBN" class="form-control"/>
                        </div>
                    </div>
                    <div class="row form-group my-3">
                        <div class="col-md-3">    
                            <h4>Description:</h4>
                        </div>
                        <div class="col-md-9">
                            <textarea type="text" maxlength="300" rows="5" name="description" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row form-group my-3">
                        <div class="col-md-3">    
                            <h4>Quantity:</h4>
                        </div>
                        <div class="col-md-3">
                            <input type="number" name="quantity" class="form-control" required/>
                        </div>
                    </div>
                    <div class="row form-group my-3">
                        <div class="col-md-3">    
                            <h4>Cost (Kshs):</h4>
                        </div>
                        <div class="col-md-3">
                            <input type="number" name="unit_cost" class="form-control"/>
                        </div>
                    </div>
                    <div class="row form-group my-3">
                        <div class="col-md-3">    
                            <h4>Loan Type:</h4>
                        </div>
                        <div class="col-md-3">
                            <select name="loan_type" class="form-control" required>
                                <option value="short_term">short term</option>
                                <option value="long_term">long term</option>
                            </select>
                        </div>
                    </div>
                    <div class="row text-center">
                        <div>
                            <input type="submit" name="submit" class="col-5 btn btn-primary" value="Add Item"/>
                        </div>
                    </div><br/>
                    <div class="row text-center">
                        <div>
                        <a class="col-5 btn btn-warning" href="view_all_library_items.php">View all Items</a>
                        </div>
                    </div>
                    <div class="row text-center my-3">
                        <div>
                            <a class="col-2 btn btn-info" href="">Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="js/jquery.validate.min.js"></script>
</body>
</html>