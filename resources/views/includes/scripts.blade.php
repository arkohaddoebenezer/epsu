@section('script')
@stack("js-scripts")
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>

<script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('js/waves.min.js') }}"></script>

<script src="{{ asset('js/modernizr.js') }}"></script>
<script src="{{ asset('js/css-scrollbars.js') }}"></script>

<script src="{{ asset('js/inputmask.js') }}"></script>
<script src="{{ asset('js/jquery.inputmask.js') }}"></script>
<script src="{{ asset('js/autonumeric.js') }}"></script>
<script src="{{ asset('js/form-mask.js') }}"></script>

<!-- select2 -->
<script src="{{ asset('js/select2.min.js') }}"></script>

<script src="{{ asset('js/bootstrap-multiselect.js') }}">
</script>
<script src="{{ asset('js/jquery.multi-select.js') }}"></script>
<script src="{{ asset('js/jquery.quicksearch.js') }}"></script>
<script src="{{ asset('js/moment-with-locales.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/moment-with-locales.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>

<script src="{{ asset('js/daterangepicker.js') }}"></script>
<script src="{{ asset('js/datedropper.min.js') }}"></script>

<script src="{{ asset('js/pcoded.min.js') }}"></script>
<script src="{{ asset('js/vertical-layout.min.js') }}"></script>
<script src="{{ asset('js/script.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $(".select2").select2({
            // Give all select2's a placeholder
            placeholder: {
                id: '-1', // the value of the option
                text: '-- Select --',
            },
            width: '100%',
            allowClear: true,
        });
    });

    function getChildren(childCode, parentListJson, parentDropdown, childDropdown) {
            let parentList = document.getElementById(parentDropdown);
            let childList = document.getElementById(childDropdown);

            let selectedIndex = parentList.options.selectedIndex;
            let selectedParentCode = parentList.options[selectedIndex].value;

            let fragment = new DocumentFragment();
            let defaultOption = new Option('--Select--', "");
            fragment.appendChild(defaultOption);

            if (selectedParentCode !== 'all' && Boolean(selectedParentCode)) {
                let selectedParent = parentListJson.find((parentListItem) => parentListItem.id == selectedParentCode);
                selectedParent.children.map(childItem => {
                    let selected = childItem.id == childCode ? true : false;
                    let option = new Option(childItem.name, childItem.id, selected, selected);
                    fragment.appendChild(option);
                });
            }

            childList.innerHTML = null;
            childList.appendChild(fragment);
        }
</script>
<script src="{{ asset('js/rocket-loader.min.js') }}" data-cf-settings="453806d6674797d39ba36b85-|49" defer=""></script>

@show
