import { __ } from "@wordpress/i18n";
import { useSelect } from "@wordpress/data";
import {
	PanelBody,
	Button,
	TextControl,
	RadioControl,
	ToggleControl,
	__experimentalInputControl as InputControl,
} from "@wordpress/components";
import {
	useBlockProps,
	InspectorControls,
	MediaUpload,
	MediaUploadCheck,
} from "@wordpress/block-editor";
import ServerSideRender from "@wordpress/server-side-render";
// Aspect ratio presets
const ASPECT_RATIO_PRESETS = {
	banner: {
		label: __("Banner", "fm-blocks"),
		desktop: "384/120",
		mobile: "8/5",
	},
	hero: {
		label: __("Hero", "fm-blocks"),
		desktop: "6/4",
		mobile: "4/5",
	},
};

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
				help={__("Overrides the attachment's alt for this slot.", "fm-blocks")}
			/>
		</PanelBody>
	);
}

export default function Edit({ attributes, setAttributes }) {
	const blockProps = useBlockProps();

	// Handle aspect ratio preset change
	const handlePresetChange = (preset) => {
		const ratios = ASPECT_RATIO_PRESETS[preset];
		if (ratios) {
			setAttributes({
				aspectRatioPreset: preset,
				ratioDesktop: ratios.desktop,
				ratioMobile: ratios.mobile,
			});
		}
	};

	// Create radio options from presets
	const radioOptions = Object.keys(ASPECT_RATIO_PRESETS).map((key) => ({
		label: ASPECT_RATIO_PRESETS[key].label,
		value: key,
	}));

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
				<PanelBody title={__("Aspect ratio", "fm-blocks")} initialOpen={false}>
					<RadioControl
						label={__("Preset", "fm-blocks")}
						selected={attributes.aspectRatioPreset || "banner"}
						options={radioOptions}
						onChange={handlePresetChange}
					/>
					<p style={{ fontSize: "12px", color: "#757575", marginTop: "8px" }}>
						{__("Banner:", "fm-blocks")} {ASPECT_RATIO_PRESETS.banner.desktop} (
						{__("desktop", "fm-blocks")}) / {ASPECT_RATIO_PRESETS.banner.mobile}{" "}
						({__("mobile", "fm-blocks")})
						<br />
						{__("Hero:", "fm-blocks")} {ASPECT_RATIO_PRESETS.hero.desktop} (
						{__("desktop", "fm-blocks")}) / {ASPECT_RATIO_PRESETS.hero.mobile} (
						{__("mobile", "fm-blocks")})
					</p>
				</PanelBody>
				<PanelBody title={__("Style", "fm-blocks")} initialOpen={false}>
					<ToggleControl
						label={__("Rounded corners", "fm-blocks")}
						checked={attributes.roundedCorners || false}
						onChange={(value) => setAttributes({ roundedCorners: value })}
						help={__("Add 25px border radius to the image", "fm-blocks")}
					/>
				</PanelBody>
				<PanelBody title={__("Link", "fm-blocks")} initialOpen={false}>
					<InputControl
						label={__("URL", "fm-blocks")}
						value={attributes.linkUrl || ""}
						onChange={(value) => setAttributes({ linkUrl: value })}
						help={__(
							"Make the image clickable. Leave empty for no link.",
							"fm-blocks",
						)}
						placeholder="https://example.com"
					/>
				</PanelBody>
			</InspectorControls>

			{/* Live server preview */}
			<ServerSideRender block="plk/front-hero" attributes={attributes} />
		</div>
	);
}
