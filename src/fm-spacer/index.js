import { registerBlockType } from "@wordpress/blocks";
import Edit from "./edit";

registerBlockType("fm/spacer", {
	edit: Edit,
	save: () => null,
});
