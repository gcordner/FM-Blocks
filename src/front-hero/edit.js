import { useBlockProps } from "@wordpress/block-editor";
import ServerSideRender from "@wordpress/server-side-render";
export default function Edit() {
	return (
		<div {...useBlockProps()}>
			<ServerSideRender block="fm/front-hero" />
		</div>
	);
}
