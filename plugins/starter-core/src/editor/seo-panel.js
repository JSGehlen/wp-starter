/**
 * "Search engines" panel in the editor's document sidebar: SEO title and
 * meta description, saved as post meta (_starter_seo_title, _starter_seo_description).
 */
import { registerPlugin } from '@wordpress/plugins';
import { PluginDocumentSettingPanel } from '@wordpress/editor';
import { TextControl, TextareaControl } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { useEntityProp } from '@wordpress/core-data';
import { store as editorStore } from '@wordpress/editor';

const t = window.starterCoreL10n || {};
const TITLE = '_starter_seo_title';
const DESC = '_starter_seo_description';

const count = ( value ) =>
	( t.characters || '%d characters' ).replace( '%d', ( value || '' ).length );

function SeoPanel() {
	const postType = useSelect( ( select ) => select( editorStore ).getCurrentPostType(), [] );
	const [ meta, setMeta ] = useEntityProp( 'postType', postType, 'meta' );

	// Only post types whose meta includes our fields (not templates, patterns…).
	if ( ! meta || ! ( TITLE in meta ) ) {
		return null;
	}

	return (
		<PluginDocumentSettingPanel name="starter-core-seo" title={ t.seoPanel || 'Search engines' }>
			<TextControl
				__next40pxDefaultSize
				__nextHasNoMarginBottom
				label={ t.seoTitle || 'Title in search results' }
				help={ `${ t.seoTitleHelp || '' } ${ count( meta[ TITLE ] ) }` }
				value={ meta[ TITLE ] || '' }
				onChange={ ( value ) => setMeta( { ...meta, [ TITLE ]: value } ) }
			/>
			<div style={ { height: '16px' } } />
			<TextareaControl
				__nextHasNoMarginBottom
				label={ t.seoDesc || 'Description in search results' }
				help={ `${ t.seoDescHelp || '' } ${ count( meta[ DESC ] ) }` }
				value={ meta[ DESC ] || '' }
				rows={ 4 }
				onChange={ ( value ) => setMeta( { ...meta, [ DESC ]: value } ) }
			/>
		</PluginDocumentSettingPanel>
	);
}

registerPlugin( 'starter-core-seo', { render: SeoPanel } );
