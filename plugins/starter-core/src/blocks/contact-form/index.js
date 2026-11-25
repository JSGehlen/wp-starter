/**
 * Contact form – editor. The form itself is rendered by PHP (render.php);
 * the editor shows that output (not clickable) and the block's settings.
 */
import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, ToggleControl, TextControl, Disabled } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';

import metadata from './block.json';
import './style.css';

const t = window.starterCoreL10n || {};

registerBlockType( metadata.name, {
	edit: ( { attributes, setAttributes } ) => (
		<div { ...useBlockProps() }>
			<InspectorControls>
				<PanelBody title={ t.formSettings || 'Form' }>
					<p>{ t.formHelp }</p>
					<ToggleControl
						__nextHasNoMarginBottom
						label={ t.showPhone || 'Show phone number field' }
						checked={ attributes.showPhone }
						onChange={ ( showPhone ) => setAttributes( { showPhone } ) }
					/>
					<TextControl
						__next40pxDefaultSize
						__nextHasNoMarginBottom
						label={ t.buttonText || 'Button text' }
						help={ t.buttonTextHelp }
						value={ attributes.buttonText }
						onChange={ ( buttonText ) => setAttributes( { buttonText } ) }
					/>
				</PanelBody>
			</InspectorControls>
			<Disabled>
				<ServerSideRender block={ metadata.name } attributes={ attributes } />
			</Disabled>
		</div>
	),
} );
