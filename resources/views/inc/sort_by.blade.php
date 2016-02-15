<ul class="sort-by">
    <li>
        [ <span>Sort By</span> ]
        <ul class="sort-by-menu">
            <li><a href="/name/{{ $type }}">Principal</a></li>
            <li><a href="/claimant/{{ $type }}">Claimant</a></li>
            <li><a href="/coc/{{ $type }}">COC</a></li>
            <li><a href="/documents/{{ $type }}">Documents</a></li>
            <li><a href="/inception/{{ $type }}">Inception</a></li>
            <li><a href="/encoded/{{ $type }}">Encoded</a></li>
            <li><a href="/amount/{{ $type }}">Amount</a></li>
            <li><a href="/stage/{{ $type }}">Stage</a></li>
            <li><a href="/claim_status/{{ $type }}">Status</a></li>
            <li><label for="type"><input id="type" type="checkbox" {{ $type == 'asc' ? 'checked' : '' }}> asc</label></li>
        </ul>
    </li>
</ul>