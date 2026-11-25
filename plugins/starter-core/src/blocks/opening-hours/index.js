/**
 * Opening hours – editor. The block is rendered by PHP (render.php) from
 * Settings → Business details; the editor shows the same server output.
 */
import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, SelectControl, Disabled } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';

import metadata from './block.json';
import './style.css';

const t = window.starterCoreL10n || {};

registerBlockType( metadata.name, {
	edit: ( { attributes, setAttributes } ) => (
		<div { ...useBlockProps() }>
			<InspectorControls>
				<PanelBody>
					<SelectControl
						__next40pxDefaultSize
						__nextHasNoMarginBottom
						label={ t.dayNames || 'Day names' }
						value={ attributes.dayFormat }
						options={ [
							{ value: 'short', label: t.short || 'Short' },
							{ value: 'long', label: t.long || 'Full' },
						] }
						onChange={ ( dayFormat ) => setAttributes( { dayFormat } ) }
					/>
				</PanelBody>
			</InspectorControls>
			<Disabled>
				<ServerSideRender block={ metadata.name } attributes={ attributes } />
			</Disabled>
		</div>
	),
} );
