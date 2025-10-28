import { __ } from "@wordpress/i18n";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import { PanelBody, RangeControl } from "@wordpress/components";

export default function Edit({ attributes, setAttributes }) {
	const blockProps = useBlockProps({
		style: {
			backgroundColor: "#f0f0f0",
			border: "1px dashed #ccc",
			minHeight: `${attributes.desktopHeight}px`,
		},
	});

	return (
		<>
			<InspectorControls>
				<PanelBody title={__("Spacer Settings", "fm-blocks")}>
					<RangeControl
						label={__("Desktop Height (px)", "fm-blocks")}
						value={attributes.desktopHeight}
						onChange={(value) => setAttributes({ desktopHeight: value })}
						min={0}
						max={500}
						step={10}
					/>
					<RangeControl
						label={__("Mobile Height (px)", "fm-blocks")}
						value={attributes.mobileHeight}
						onChange={(value) => setAttributes({ mobileHeight: value })}
						min={0}
						max={300}
						step={10}
					/>
					<p style={{ fontSize: "12px", color: "#757575", marginTop: "8px" }}>
						{__("Desktop:", "fm-blocks")} {attributes.desktopHeight}px
						<br />
						{__("Mobile:", "fm-blocks")} {attributes.mobileHeight}px
					</p>
				</PanelBody>
			</InspectorControls>

			<div {...blockProps}>
				<div
					style={{
						textAlign: "center",
						paddingTop: `${attributes.desktopHeight / 2 - 10}px`,
						color: "#999",
						fontSize: "14px",
					}}
				>
					↕ {attributes.desktopHeight}px
				</div>
			</div>
		</>
	);
}
