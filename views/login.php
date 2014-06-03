<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="glyphicon glyphicon-lock"></span> Identification</div>
                <div class="panel-body">
                    <form method="post" class="form-horizontal" role="form" action="index.php?afficher=connexion" >
                    <div class="form-group">
                        <label for="inputLogin" class="col-sm-3 control-label">
                            Login</label>
                        <div class="col-sm-9">
                            <input type="login" name="login" class="form-control" id="inputLogin" placeholder="Login" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword" class="col-sm-3 control-label">
                            Password</label>
                        <div class="col-sm-9">
                            <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password" required>
                        </div>
                    </div>
                   
                    <div class="form-group last">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button type="submit" class="btn btn-success btn-sm">
                                Valider</button>
                                 <button type="reset" class="btn btn-default btn-sm">
                                Réinitialiser</button>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="panel-footer">
                    Bibliothèque INSA Rennes</div>
            </div>
        </div>
    </div>
</div>
