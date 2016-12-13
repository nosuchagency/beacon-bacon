jQuery( 'document' ).ready( function ( ) {

  /* Provide "Are you sure?" to ALL DANGER buttons */
  jQuery( 'input.btn-danger' ).click( function ( event ) {
    var button = jQuery( this );
    var are_you_sure = button.data( 'are-you-sure' );

    if ( are_you_sure == 'Yes' ) {
      return true;
    }

    button.val( 'Are you sure?' );
    button.data( 'are-you-sure', 'Yes' );

    return false;
  } );

  jQuery( '#hide_pois_checkbox' ).click( function ( event ) {
    $( '.poi-in-list').toggle( ! this.checked );
    $( '.poi-on-map-preview').toggle( ! this.checked );

    jQuery.cookie( 'hide-pois', this.checked );
  } );

  if ( jQuery.cookie( 'hide-pois' ) == 'true' ) {
    jQuery( '#hide_pois_checkbox' ).prop( 'checked', true );

    $( '.poi-in-list' ).toggle( false );
    $( '.poi-on-map-preview' ).toggle( false );
  }
  

  jQuery( '#hide_beacons_checkbox' ).click( function ( event ) {
    $( '.beacon-in-list').toggle( ! this.checked );
    $( '.beacon-on-map-preview').toggle( ! this.checked );

    jQuery.cookie( 'hide-beacons', this.checked );
  } );

  if ( jQuery.cookie( 'hide-beacons' ) == 'true' ) {
    jQuery( '#hide_beacons_checkbox' ).prop( 'checked', true );

    $( '.beacon-in-list' ).toggle( false );
    $( '.beacon-on-map-preview' ).toggle( false );
  }


  jQuery( '#hide_blocks_checkbox' ).click( function ( event ) {
    $( '.block-in-list' ).toggle( ! this.checked );

    jQuery.cookie( 'hide-blocks', this.checked );
  } );

  if ( jQuery.cookie( 'hide-blocks' ) == 'true' ) {
    jQuery( '#hide_blocks_checkbox' ).prop( 'checked', true );

    $( '.block-in-list' ).toggle( false );
  }


  jQuery( '#hide_findables_checkbox' ).click( function ( event ) {
    $( '.findable-in-list' ).toggle( ! this.checked );
    $( '.findable-on-map-preview' ).toggle( ! this.checked );

    jQuery.cookie( 'hide-findables', this.checked );
  } );

  if ( jQuery.cookie( 'hide-findables' ) == 'true' ) {
    jQuery( '#hide_findables_checkbox' ).prop( 'checked', true );

    $( '.findable-in-list' ).toggle( false );
    $( '.findable-on-map-preview' ).toggle( false );
  }

} );
