<div class="card">
    <a href="{{$profile['assetProfile']['website']}}" target="_blank">
        <img class="card-img-top img-size-64" src="{{$logo['logos'][0]['formats'][0]['src']}}" alt="avatar">
        <label>
            <input hidden type="text" name="avatar"
                   value={{$logo['logos'][0]['formats'][0]['src']}}>
        </label>
    </a>
    <div class="card-body">
        <h5 class="card-title">{{$profile['quoteType']['shortName']}}</h5>
        <h6 class="card-title text-muted">{{$profile['assetProfile']['sector']}}</h6>
        <p class="card-text" style="text-align: justify">{{strtok($profile['assetProfile']['longBusinessSummary'], '.')}}</p>
        <label>
            <input hidden type="text" name="code" value="{{$symbol}}">
            <input hidden type="text" name="name" value="{{$profile['quoteType']['shortName']}}">
            <input hidden type="text" name="sector" value="{{$profile['assetProfile']['sector']}}">
            <input hidden type="text" name="summary"
                   value="{{$profile['assetProfile']['longBusinessSummary']}}">
        </label>
        <button type="submit" class="btn btn-block btn-danger">Save</button>
    </div>
</div>
