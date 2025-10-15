<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <script>document.write(new Date().getFullYear())</script> © {{ app()->getLocale() == 'en' ? $authUser->company->name_en : $authUser->company->name_ar  }}
            </div>
        </div>
    </div>
</footer>