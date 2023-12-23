import { test, expect, describe } from "vitest";
import { shallowMount } from "@vue/test-utils";
import BaseButton from "@/components/BaseButton.vue";

describe("BaseButton", () => {
    test("mounts successfully", () => {
        const wrapper = shallowMount(BaseButton);
        const button = wrapper.find("button");
        expect(button).toBeTruthy();
    });

    test("Loading state is false by deafult", () => {
        const wrapper = shallowMount(BaseButton);
        expect(wrapper.props().loading).toBe(false);
    });
});
