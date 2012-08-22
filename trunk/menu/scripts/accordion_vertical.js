  
    $(document).ready(function() {
    	var icons = {
			header: "ui-icon-circle-arrow-e",
			headerSelected: "ui-icon-circle-arrow-s"
		};
        $('#accordion').accordion({
        	icons: icons,
        	autoHeight: false,
        	clearStyle: true,
        	//header: 'menu_heading',
        	collapsible: true
        });
        
		
    });  
