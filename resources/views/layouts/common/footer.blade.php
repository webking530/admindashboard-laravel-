<footer class="footer">
  <div class="col">
    {{-- <div class="text-center">
      Currently	active	users:
      &nbsp;<span class="text-info">1</span>
    </div> --}}
    <div class="text-center">
      <span class="text-warning">
        {{-- {{'10/01/2020 00:00:00'}} --}}
        {{date('m/d/Y H:i:s')}}
      </span>
    </div>
    <div class="text-center">
      Page generated in <span class="text-danger generated-time">{{round(microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"], 4)}}</span> seconds.
    </div>
  </div>
</footer>