import { __ } from "@wordpress/i18n";
import { useSelect } from "@wordpress/data";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import ServerSideRender from "@wordpress/server-side-render";
import { MediaUpload, MediaUploadCheck } from "@wordpress/block-editor";
import { PanelBody, Button, TextControl } from "@wordpress/components";

function ImagePicker({ label, idAttr, altAttr, attributes, setAttributes }) {
	const id = attributes[idAttr];
	const alt = attributes[altAttr];

	const media = useSelect(
		(select) => (id ? select("core").getMedia(id) : null),
		[id],
	);

	return (
		<PanelBody title={label} initialOpen={true}>
			<MediaUploadCheck>
				<MediaUpload
					onSelect={(m) => setAttributes({ [idAttr]: m?.id })}
					allowedTypes={["image"]}
					value={id}
					render={({ open }) => (
						<div>
							{media ? (
								<div style={{ marginBottom: 8 }}>
									<img
										src={
											media?.media_details?.sizes?.medium?.source_url ||
											media?.source_url
										}
										alt={media?.alt_text || ""}
										style={{
											maxWidth: "100%",
											height: "auto",
											display: "block",
										}}
									/>
								</div>
							) : (
								<p>{__("No image selected", "fm-blocks")}</p>
							)}
							<Button variant="primary" onClick={open}>
								{id
									? __("Replace image", "fm-blocks")
									: __("Select image", "fm-blocks")}
							</Button>
							{id && (
								<Button
									variant="secondary"
									onClick={() => setAttributes({ [idAttr]: undefined })}
									style={{ marginLeft: 8 }}
								>
									{__("Remove", "fm-blocks")}
								</Button>
							)}
						</div>
					)}
				/>
			</MediaUploadCheck>

			<TextControl
				label={__("Custom alt (optional)", "fm-blocks")}
				value={alt || ""}
				onChange={(v) => setAttributes({ [altAttr]: v })}
				help={__("Overrides the attachment’s alt for this slot.", "fm-blocks")}
			/>
		</PanelBody>
	);
}

export default function Edit({ attributes, setAttributes }) {
	const blockProps = useBlockProps();

	return (
		<div {...blockProps}>
			<InspectorControls>
				<ImagePicker
					label={__("Desktop image", "fm-blocks")}
					idAttr="desktopId"
					altAttr="desktopAlt"
					attributes={attributes}
					setAttributes={setAttributes}
				/>
				<ImagePicker
					label={__("Mobile image (A)", "fm-blocks")}
					idAttr="mobile1Id"
					altAttr="mobile1Alt"
					attributes={attributes}
					setAttributes={setAttributes}
				/>
				<ImagePicker
					label={__("Mobile image (B)", "fm-blocks")}
					idAttr="mobile2Id"
					altAttr="mobile2Alt"
					attributes={attributes}
					setAttributes={setAttributes}
				/>
				<PanelBody title={__("Aspect ratios", "fm-blocks")} initialOpen={false}>
					<TextControl
						label={__("Desktop ratio (w/h)", "fm-blocks")}
						value={attributes.ratioDesktop || ""}
						onChange={(v) => setAttributes({ ratioDesktop: v })}
						help={__("e.g. 6/4", "fm-blocks")}
					/>
					<TextControl
						label={__("Mobile ratio (w/h)", "fm-blocks")}
						value={attributes.ratioMobile || ""}
						onChange={(v) => setAttributes({ ratioMobile: v })}
						help={__("e.g. 4/5", "fm-blocks")}
					/>
				</PanelBody>
			</InspectorControls>

			{/* Live server preview */}
			<ServerSideRender block="fm/front-hero" attributes={attributes} />
		</div>
	);
}
