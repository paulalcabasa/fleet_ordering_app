<div class="kt-timeline-v2">
    <div class="kt-timeline-v2__items  kt-padding-top-25 kt-padding-bottom-30">
        @foreach($timeline as $row)
        <div class="kt-timeline-v2__item">
            <span class="kt-timeline-v2__item-time" style="color:#6a6d7e !important;">
                <?php echo date("H:i", strtotime($row->raw_date)); ?>
            </span>
            <div class="kt-timeline-v2__item-cricle">
                <i class="fa fa-genderless kt-font-danger"></i>
            </div>
            <div class="kt-timeline-v2__item-text  kt-padding-top-5" style="color:#6a6d7e !important;">
                <?php echo $row->content; ?>
                <p style="font-size:11px;color:#a7abc3 !important;">{{ Carbon\Carbon::parse($row->raw_date)->diffForHumans() }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>